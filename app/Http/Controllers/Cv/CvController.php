<?php

namespace App\Http\Controllers\Cv;

use App\Http\Controllers\Controller;
use App\Models\Cv;
use App\Models\DatedData;
use App\Models\DatedSection;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CvController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $cvs = auth()->user()->cvs;
        return  response()->json($cvs);
    }
    // create cv
    public function create(Request $request)
    {
        $data = $request->all();
        // creating cv
        $cv = $request->user()->cvs()->create($data['info']);
        // create experiences
        foreach ($data['experiences'] as $experience) {
            $cv->experiences()->create($experience);
        }
        // create educations
        foreach ($data['educations'] as $education) {
            $cv->educations()->create($education);
        }
        // create sections
        foreach ($data['sections'] as $section) {
            $cv->sections()->create($section);
        }
        // create datedSections
        foreach ($data['datedSections'] as $datedSection) {
            $dated = $cv->datedSections()->create($datedSection);
            foreach ($datedSection['data'] as $data) {
                $dated->datedData()->create($data);
            }
        }
        return response()->json([$data], 200);
    }
    // // edit cv
    public function getCv(Cv $cv)
    {
        $educations = $cv->educations()->get();
        $sections = $cv->sections()->get();
        $experiences = $cv->experiences()->get();
        $datedSectionssss = $cv->datedSections()->get();
        $datedSections = [];
        foreach ($datedSectionssss as $section) {
            array_push($datedSections, [
                'id' => $section->id,
                'heading' => $section->heading,
                'data' => $section->datedData()->get()
            ]);
        }
        return response()->json([
            'info' => $cv,
            'experiences' => $experiences,
            'sections' => $sections,
            'educations' => $educations,
            'datedSections' => $datedSections
        ]);
    }
    // update cv
    public function update(Request $request, CV $cv)
    {
        $data = $request->all();
        // update cv
        // $cv->update($data['info']);
        // create or update exp
        foreach ($data['experiences'] as $experience) {
            if (isset($experience['id'])) {
                Experience::where('id', $experience['id'])->update($experience);
            } else {
                $cv->experiences()->create($experience);
            }
        }
        // create or update educations
        foreach ($data['educations'] as $education) {
            if (isset($education['id'])) {
                Education::where('id', $education['id'])->update($education);
            } else {
                $cv->educations()->create($education);
            }
        }
        // create or update sections
        foreach ($data['sections'] as $section) {
            if (isset($section['id'])) {
                Section::where('id', $section['id'])->update($section);
            } else {
                $cv->sections()->create($section);
            }
        }
        //create or update dated sections
        foreach ($data['datedSections'] as $dateSection) {
            if (isset($dateSection['id'])) {
                foreach ($dateSection['data'] as $data) {
                    if (!isset($data['id'])) {
                        $dateSection->data()->create($data);
                    } else {
                        DatedData::where('id', $data['id'])->update($data);
                    }
                }
            } else {
                $dated = $cv->datedSections()->create($dateSection);
                foreach ($dateSection['data'] as $data) {
                    $dated->datedData()->create($data);
                }
            }
        }
        // create dated sections
        return response()->json($data, 201);
    }

    // deleteEducation
    public function deleteEducation(Cv $cv, Education $education)
    {
        $education->delete();
        return response()->json(["message" => "Successfully deleted."]);
    }
    // // deleteEducation
    public function deleteExp(Cv $cv, Experience $experience)
    {
        $experience->delete();
        return response()->json(["message" => "Successfully deleted."]);
    }
    // // delete section
    public function deleteSection(Cv $cv, Section $section)
    {
        $section->delete();
        return response()->json(["message" => "Successfully deleted."]);
    }
    //delete dated section
    public function deleteDateSec(Cv $cv, DatedSection $datedSection)
    {
        $datedSection->delete();
        return response()->json(["message" => "Successfully deleted."]);
    }
    //delete dated section
    public function deleteDateData(DatedSection $datedSection, DatedData $datedData)
    {
        $datedData->delete();
        return response()->json(["message" => "Successfully deleted."]);
    }
    //delete cv
    public function destroy(Cv $cv)
    {
        if (auth()->user()->id == $cv->user_id) {
            $cv->delete();
            return response()->json(["message" => "Successfully deleted."]);
        } else {
            return abort(403);
        }
    }
}
