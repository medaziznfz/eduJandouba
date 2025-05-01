<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UniversityValidationController extends Controller
{
    /**
     * Affiche la page de validations pour le validateur université.
     */
    public function index()
    {
        // si vous avez des données à passer, vous pouvez les charger ici,
        // p.ex. les demandes ou les formations à valider
        // $items = ...;

        return view('univ.validations' /*, compact('items') */);
    }
}
