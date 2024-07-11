<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreTestimonialsRequest;
use App\Http\Requests\UpdateTestimonialsRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTestimonialsRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TestimonialController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {   
        abort_if(Gate::denies('testimonial_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $testimonials = Testimonial::with(['media'])->get();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        abort_if(Gate::denies('testimonial_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.testimonials.create');
    }

    public function store(StoreTestimonialsRequest $request)
    {
        $testimonials = Testimonial::create($request->all());

        if ($request->input('image', false)) {
            $testimonials->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $testimonials->id]);
        }

        return redirect()->route('admin.testimonials.index');
    }

    public function edit(Testimonial $testimonial)
    {
        abort_if(Gate::denies('testimonial_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(UpdateTestimonialsRequest $request, Testimonial $testimonial)
    {
        $testimonial->update($request->all());

        if ($request->input('image', false)) {
            if (! $testimonial->image || $request->input('image') !== $testimonial->image->file_name) {
                if ($testimonial->image) {
                    $testimonial->image->delete();
                }
                $testimonial->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($testimonial->image) {
            $testimonial->image->delete();
        }

        return redirect()->route('admin.testimonials.index');
    }

    public function show(Testimonial $testimonial)
    {
        abort_if(Gate::denies('testimonial_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.testimonials.show', compact('testimonial'));
    }

    public function destroy(Testimonial $testimonial)
    {
        abort_if(Gate::denies('testimonial_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $testimonial->delete();

        return back();
    }

    public function massDestroy(MassDestroyTestimonialsRequest $request)
    {
        $testimonials = Testimonial::find(request('ids'));

        foreach ($testimonials as $testimonial) {
            $testimonial->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('testimonial_create') && Gate::denies('testimonial_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Testimonial();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
