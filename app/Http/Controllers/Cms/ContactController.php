<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $contacts = Contact::get();

        return view('contacts.index', compact('contacts'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(): JsonResponse
    {
        $this->validation();

        $contact = new Contact;

        $contact->name = request('name');
        $contact->email = request('email');

        return response()->json($contact->save());
    }

    /**
     * @param \App\Models\Contact $contact
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Contact $contact): JsonResponse
    {
        $this->validation();

        return response()->json($contact->update([
            'name' => request('name'),
            'email' => request('email'),
        ]));
    }

    /**
     * @param \App\Models\Contact $contact
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function destroy(Contact $contact): JsonResponse
    {
        return response()->json($contact->delete());
    }

    /**
     * @return array|bool|null
     */
    public function validation()
    {
        return request()->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
    }
}
