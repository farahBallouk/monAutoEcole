<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'reservations'=> Reservation::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function demande_reservation(Request $request)
    {
        try {
            $request->validate([
                'id_autoEcole' => 'required',
                'id_candidat' => 'required',
                'date' => 'required|date',
                'duree' => 'required',
            ]);
    
            $reservation = new Reservation;
            $reservation->id_autoEcole = $request->id_autoEcole;
            $reservation->id_candidat = $request->id_candidat;
            $reservation->date = $request->date;
            $reservation->duree = $request->duree;
            $reservation->save();
    
            return response()->json([
                'message' => 'Réservation bien insérée',
                'status' => 'succes',
                'data' => $reservation
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la réservation',
                'status' => 'erreur',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $idReservation = $request->input('id_reservation');
            $reservation = Reservation::find($idReservation);
            
            if (!$reservation) {
                return response()->json(['message' => 'Réservation non trouvée'], 404);
            }
            
            $dateLimiteAnnulation = Carbon::parse($reservation->created_at)->addHours(12);
            $maintenant = Carbon::now();
            
            if ($maintenant->lt($dateLimiteAnnulation)) {
                $reservation->delete();
                
                return response()->json([
                    'message' => 'La réservation a été supprimée avec succès.',
                    'status' => 'success'
                ]);
            } else {
                return response()->json([
                    'message' => 'Impossible d\'annuler la réservation après 12 heures.',
                    'status' => 'error'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la suppression de la réservation',
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function accepterReservation(Request $request)
    {
        try {
            $id_reservation = $request->input('id_reservation');
    
            // Trouvez la réservation en fonction de son ID
            $reservation = Reservation::find($id_reservation);
    
            // Vérifiez si la réservation existe
            if (!$reservation) {
                return response()->json([
                    'message' => 'La réservation n\'existe pas',
                    'status' => 'erreur'
                ], 404);
            }
    
            // Mettez à jour la réservation avec la décision "accepté"
            $reservation->status = 'accepté';
            $reservation->save();
    
            return response()->json([
                'message' => 'La réservation a été acceptée avec succès',
                'status' => 'succes',
                'data' => $reservation
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de l\'acceptation de la réservation',
                'status' => 'erreur',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    public function reporterReservation(Request $request)
    {
        try {
            $id_reservation = $request->input('id_reservation');
    
            // Trouvez la réservation en fonction de son ID
            $reservation = Reservation::find($id_reservation);
    
            // Vérifiez si la réservation existe
            if (!$reservation) {
                return response()->json([
                    'message' => 'La réservation n\'existe pas',
                    'status' => 'erreur'
                ], 404);
            }
    
            // Mettez à jour la réservation avec la décision "reporté"
            $reservation->status = 'reporté';
            $reservation->save();
    
            return response()->json([
                'message' => 'Réservation reportée avec succès',
                'status' => 'succes',
                'data' => $reservation
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors du report de la réservation',
                'status' => 'erreur',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    public function refuserReservation(Request $request)
    {
        try {
            $id_reservation = $request->input('id_reservation');
    
            // Trouvez la réservation en fonction de son ID
            $reservation = Reservation::find($id_reservation);
    
            // Vérifiez si la réservation existe
            if (!$reservation) {
                return response()->json([
                    'message' => 'La réservation n\'existe pas',
                    'status' => 'erreur'
                ], 404);
            }
    
            // Mettez à jour la réservation avec la décision "refusé"
            $reservation->status = 'refusé';
            $reservation->save();
    
            return response()->json([
                'message' => 'Réservation refusée avec succès',
                'status' => 'succes',
                'data' => $reservation
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors du refus de la réservation',
                'status' => 'erreur',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    


    
    // public function update(Request $request, Reservation $reservation)
    // {
    //     $reservation->id_autoEcole = $request->id_autoEcole;
    //     $reservation->id_candidat = $request->id_candidat;
    //     $reservation->Date = $request->Date;
    //     $reservation->status = $request->status;
    //     $reservation->save();
    //     return response()->json([
    //         'message'=>'reservation bien modifie',
    //         'status'=>'succes',
    //         'data'=> $reservation
    //     ]);
    // }

}
