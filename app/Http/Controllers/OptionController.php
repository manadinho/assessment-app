<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Http\Requests\OptionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class OptionController
 * @package App\Http\Controllers\OptionController
 * 
 * @author Muhammad Imran Israr (mimranisrar6@gmail.com)
 */
class OptionController extends Controller
{
    /**
     * Retrieve and display the options in the index view.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View 
    {
        $options = Option::all();
        return view('options.index', ['options' => $options]);
    }

    /**
     * Store or update an option.
     *
     * This function stores or updates an option in the database based on the provided request data.
     *
     * @param \App\Http\Requests\OptionRequest $request The validated option request instance.
     *
     * @return \Illuminate\Http\RedirectResponse A redirect response to the options index page with a success message.
     */
    public function store(OptionRequest $request): RedirectResponse
    {
        Option::updateOrCreate(['id' => $request->id], $request->only('name', 'price'));
        $message = ($request->id) ? 'Option updated!':'Option created!' ;
        return redirect()->route('options.index')->with('success', $message);
    }

    /**
     * Edit an Option.
     *
     * This function is responsible for rendering the view for editing an Option
     * based on the provided Option object.
     *
     * @param Option $option The Option object to be edited.
     * @return View The rendered view for editing the Option.
     */
    public function edit(Option $option): View
    {
        return view('options.create', ['option' => $option]);
    }

    /**
     * Delete an Option from the database.
     *
     * This function is responsible for deleting an Option object from the database.
     * It takes an instance of the Option model as a parameter and deletes it from the database.
     *
     * @param Option $option The Option model instance to be deleted.
     *
     * @return RedirectResponse Returns a RedirectResponse object.
     * The user will be redirected to the 'options.index' route on successful deletion with a success message.
     * If an error occurs during the deletion process, the user will be redirected back to the previous page with an error message.
     */
    public function delete(Option $option): RedirectResponse
    {
        try{
            $option->delete();
            return redirect()->route('options.index')->with('success', 'Option deleted!');
        } catch (\Throwable $th) {
            return back()->with('fail', $th->getMessage());
        }
    }
}
