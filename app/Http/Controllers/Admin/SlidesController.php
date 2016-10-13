<?php

namespace App\Http\Controllers\Admin;

use App\SiteContent\Slide;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SlidesController extends Controller
{

    public function index()
    {
        $slides = Slide::inOrder();

        return view('admin.content.slides.index')->with(compact('slides'));
    }

    public function create()
    {
        $slide = Slide::createDefault();

        return redirect('admin/slides/' . $slide->id . '/edit');
    }

    public function edit(Slide $slide)
    {
        return view('admin.content.slides.edit')->with(compact('slide'));
    }

    public function update(Request $request, Slide $slide)
    {
        $this->validate($request, [
            'slide_text' => 'max:255',
            'action_text' => 'max:255',
            'action_link' => 'max:255',
            'text_colour' => 'in:dark,white,brand'
        ]);

        $slide->update($request->only(['slide_text', 'action_text', 'action_link', 'text_colour']));

        return $slide;
    }

    public function delete(Slide $slide)
    {
        $slide->delete();
        return redirect('admin/slides');
    }

}
