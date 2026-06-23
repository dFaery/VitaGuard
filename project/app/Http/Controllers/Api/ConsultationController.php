<?php

namespace App\Http\Controllers\Api  ;

use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\Consultation;
use App\Models\OnlineSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();
        $specialties = Specialty::all();
        return view('pages.consultations.index', compact('doctors', 'specialties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function fetchConsultations()
    {
        $user = auth()->user();

        if ($user->role === 'doctor') {
            $sessionIds = OnlineSession::where('doctor', $user->username)->pluck('id');

            $consultations = Consultation::with('onlineSession')
                ->whereIn('online_session_id', $sessionIds)
                ->orderBy('start_time', 'desc')
                ->get();
        } else {
            $consultations = Consultation::with('onlineSession')
                ->where('patient', $user->username)
                ->orderBy('start_time', 'desc')
                ->get();
        }

        $data = $consultations->map(function ($c) {
            return [
                'id'         => $c->id,
                'patient'    => $c->patient,
                'doctor'     => $c->onlineSession->doctor ?? '-',
                'start_time' => $c->start_time ? $c->start_time->format('d M Y H:i') : '-',
                'end_time'   => $c->end_time ? $c->end_time->format('d M Y H:i') : null,
                'notes'      => $c->notes,
                'is_active'  => is_null($c->end_time),
                'chat_url'   => '/chat/' . $c->id,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    public function doctorPage()
    {
        return view('pages.consultations.doctor');
    }

    public function memberPage()
    {
        return view('pages.consultations.member');
    }
}
