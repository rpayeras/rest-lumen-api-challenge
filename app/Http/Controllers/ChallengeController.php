<?php

namespace App\Http\Controllers;

use App\Models\Attendant;
use App\Models\Member;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChallengeController extends Controller
{

    public function index(){
        return 'Challenge Api';
    }

    /**
     * @api {get} /challenge/teams Teams list
     * @apiName Teams list
     * @apiGroup Challenge
     *
     * @apiHeader {String} Token Auth token.
     *
     * @apiParam {String} filter Filter results
     * @apiParam {String} offset Offset results
     * @apiParam {String} limit Limit results
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *   [
     *     {
     *       "id": 33,
     *       "name": "Enterprise",
     *       "brand": "Yamaha",
     *       "model": "MT-230X1",
     *       "loa": "23.20",
     *       "draft": "23.50",
     *       "beam": "12.20",
     *       "sail_number": "ABD-12343",
     *       "date_arrival": "2021-03-11 22:00:00",
     *       "date_departure": "2021-03-15 09:00:00",
     *       "class": "YACHT",
     *       "external_diver_required": null,
     *       "car_plate_number": "1234QQQ",
     *       "container_size": "23.50",
     *       "boat_id": null,
     *       "created_at": "2021-03-16T13:23:41.000000Z",
     *       "updated_at": "2021-03-16T13:24:45.000000Z"
     *   }
     * ]
     */
    public function getTeams(){
        return response()->json(Team::get());
    }

    /**
     * @api {post} /challenge/teams Insert team with members and documents
     * @apiName Insert team
     * @apiGroup Challenge
     *
     * @apiHeader {String} Token Auth token.
     *
     * @apiParam {String} name  Name of the team
     * @apiParam {String} brand Brand of boat
     * @apiParam {String} model Model of boat
     * @apiParam {Decimal} loa
     * @apiParam {Decimal} draft
     * @apiParam {Decimal} beam
     * @apiParam {String} class Class of boat
     * @apiParam {String} sail_number
     * @apiParam {Datetime} date_arrival
     * @apiParam {Datetime} date_departure
     * @apiParam {Decimal} [container_size]
     * @apiParam {Object} members
     * @apiParam {String} members[firstname]
     * @apiParam {String} members[lastname]
     * @apiParam {String} members[phone]
     * @apiParam {String} members[email]
     * @apiParam {String} members[nationality]
     * @apiParam {Object} documents
     * @apiParam {String} documents[name]
     * @apiParam {String} documents[type] Type of document as Insurance
     * @apiParam {File} documents[file] File types xls, doc, jpg, png files
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *      {
     *      "data": {"id": 33},
     *      }
     */
    public function storeTeam(Request $request){
        $data = $request->all();
        $data['sail_number'] = !empty($data['sail_number']) ? $data['sail_number'] : '';

        $team = Team::where('external_id', $data['external_id'])
            ->where('sail_number', $data['sail_number'])->first();

        if(!empty($team)){
            $controller = new ChallengeController();
            return $controller->updateTeam($request);
        }

        $this->validate($request, [
            'name' => 'required|min:3',
            'brand' => 'min:3',
            'model' => 'min:1',
            'loa' => 'required|numeric',
            'draft' => 'numeric',
            'beam' => 'numeric',
            'class' => 'alpha|min:3',
            'sail_number' => 'min:1',
            'date_arrival' => 'required|date',
            'date_departure' => 'required|date',
            'container_size' => 'numeric',
            'company_address' => 'min:3',
            'company_name' => 'min:3',
            'company_vat' => 'min:3',
            'company_zip_city' => 'min:3',
            'external_id' => 'required|numeric',
            'members.*' => 'array',
            'members.*.firstname' => 'required|min:3',
            'members.*.lastname' => 'required|min:3',
            'members.*.email' => 'email',
            'members.*.category_id' => 'required|numeric',
            'members.*.external_id' => 'required|numeric',
            'documents' => 'array',
            'documents.*' => 'required|mimes:jpg,png,pdf,doc,xls,xlsx',
        ]);

        $team = Team::create($data);
        $folder = base_path('storage/app/challenge/documents/'.$team->id);

        $docs = [];

        if(!empty($data['documents'])){

            foreach($data['documents'] as $document){
                $newDoc = [];
                $newDoc['name'] = Str::slug(substr($document->getClientOriginalName(),0, strpos($document->getClientOriginalName(), '.')) ).'.'.$document->extension();
                $newDoc['type'] = 'test';
                $path = $folder.'/'.$newDoc['name'];

                if (!file_exists($folder)) {
                    mkdir($folder, 0711, true);
                }

                if(file_exists($path)){
                    unlink($path);
                }

                file_put_contents($path, $document->get());

                if($team->documents()->where('name', $newDoc['name'])->exists()){
                    $team->documents()->where('name', $newDoc['name'])->update($newDoc);
                } else {
                    $team->documents()->create($newDoc);
                }
            }

            $team->documents()->createMany($docs);
        }

        if(!empty($data['members'])) {
            if(!is_array($data['members'])){
                $data['members'] = json_decode($data['members'], true);
            }

            $team->members()->createMany($data['members']);
        }

        return response()->json(['data' => ['id' => $team->id]]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Validation\ValidationException
     *
     * @api {post} /challenge/teams/:id Update a team with members and documents
     * @apiName Update team
     * @apiGroup Joysail
     *
     * @apiHeader {String} Token Auth token.
     *
     * @apiParam {String} name  Name of the team
     * @apiParam {String} brand Brand of boat
     * @apiParam {String} model Model of boat
     * @apiParam {Decimal} loa
     * @apiParam {Decimal} draft
     * @apiParam {Decimal} beam
     * @apiParam {String} class
     * @apiParam {String} sail_number
     * @apiParam {Datetime} date_arrival
     * @apiParam {Datetime} date_departure
     * @apiParam {Decimal} container_size
     * @apiParam {Object} members
     * @apiParam {String} members[firstname]
     * @apiParam {String} members[lastname]
     * @apiParam {String} members[phone]
     * @apiParam {String} members[email]
     * @apiParam {String} members[nationality]
     * @apiParam {Object} documents
     * @apiParam {String} documents[name]
     * @apiParam {String} documents[type] Type of document as Insurance
     * @apiParam {File} documents[file] File types xls, doc, jpg, png files
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     */
    public function updateTeam(Request $request){
        $team = Team::where('external_id', $request->external_id)
            ->where('sail_number', $request->sail_number)->first();

        if(empty($team)){
            return response('', 404);
        }

        $data = $request->all();

        $this->validate($request, [
            'name' => 'min:3',
            'brand' => 'min:3',
            'model' => 'min:1',
            'loa' => 'numeric',
            'draft' => 'numeric',
            'beam' => 'numeric',
            'class' => 'alpha|min:3',
            'sail_number' => 'min:1',
            'date_arrival' => 'date',
            'date_departure' => 'date',
            'container_size' => 'numeric',
            'company_address' => 'min:3',
            'company_name' => 'min:3',
            'company_vat' => 'min:3',
            'company_zip_city' => 'min:3',
            'external_id' => 'numeric',
            'members.*' => 'array',
            'members.*.firstname' => 'required|min:3',
            'members.*.lastname' => 'required|min:3',
            'members.*.phone' => 'min:3',
            'members.*.email' => 'email',
            'members.*.category_id' => 'required|numeric',
            'members.*.external_id' => 'required|numeric',
            'documents' => 'array',
            'documents.*' => 'required|mimes:jpg,png,pdf,doc,xls,xlsx',
        ]);

        $team->update($data);

        if(!empty($data['members'])){
            if(!is_array($data['members'])){
                $data['members'] = json_decode($data['members'], true);
            }

            foreach($data['members'] as $member){
                if($team->members()->where('external_id', $member['external_id'])->where('category_id', $member['category_id'])->exists()){
                    $team->members()->where('external_id', $member['external_id'])->where('category_id', $member['category_id'])->update($member);
                } else {
                    $team->members()->create($member);
                }
            }
        }

        if(isset($data['documents'])){
            $folder = base_path('storage/app/challenge/documents/'.$team->id);

            foreach($data['documents'] as $document){

                $newDoc = [];
                $newDoc['name'] = Str::slug(substr($document->getClientOriginalName(),0, strpos($document->getClientOriginalName(), '.')) ).'.'.$document->extension();
                $newDoc['type'] = 'test';
                $path = $folder.'/'.$newDoc['name'];

                if (!file_exists($folder)) {
                    mkdir($folder, 0711, true);
                }

                if(file_exists($path)){
                    unlink($path);
                }

                file_put_contents($path, $document->get());

                if($team->documents()->where('name', $newDoc['name'])->exists()){
                    $team->documents()->where('name', $newDoc['name'])->update($newDoc);
                } else {
                    $team->documents()->create($newDoc);
                }
            }
        }

        return response()->json(['data' => ['id' => $team->id]]);
    }

    public function getMembers(){
        return response()->json(Member::get());
    }

    /**
     * @api {get} /challenge/members/categories Member categories list
     * @apiName Members categories list
     * @apiGroup Challenge
     *
     * @apiHeader {String} Token Auth token.
     *
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     [
     *         {
     *           "id": 1,
     *           "name": "Team Manager"
     *         },
     *         {
     *           "id": 2,
     *           "name": "Captain"
     *         },
     *         {
     *           "id": 3,
     *           "name": "Crew"
     *         },
     *         {
     *           "id": 4,
     *           "name": "Owner"
     *         },
     *         {
     *           "id": 5,
     *           "name": "Diver"
     *         }
     *     ]
     */
    public function getMembersCategories(){
        $data = app('db')->select("SELECT id, name FROM challenge_categories_members");
        return response()->json($data);
    }

    public function getAttendants(){
        return response()->json(Attendant::get());
    }

    /**
     * @api {post} /challenge/attendants Store an attendant
     * @apiName Attendants
     * @apiGroup Challenge
     *
     * @apiHeader {String} Token Auth token.
     *
     * @apiParam {String} firstname
     * @apiParam {String} lastname
     * @apiParam {String} email
     * @apiParam {String} phone
     * @apiParam {String} [position]
     * @apiParam {String} [company]
     * @apiParam {String} [media] Media sector (Outlet)
     * @apiParam {String} [media_category] Nautic / Lifestyle / General
     * @apiParam {String} [media_department] Editorial / Advertisement
     * @apiParam {Integer} type_id Get it from /challenge/attendants/types (Selection Guest/Media/Sponsors/Collab)
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *      {
     *      "data": {"id": 33},
     *      }
     */
    public function storeAttendant(Request $request){
        $data = $request->all();
        $attendant = Attendant::where('external_id', $data['external_id'])->first();

        if(!empty($attendant)){
            $controller = new ChallengeController();
            return $controller->updateAttendant($request);
        }

        $this->validate($request, [
            'firstname' => 'required|min:3',
            'lastname' => 'min:3',
            'email' => 'email|min:3',
            'phone' => 'min:3',
            'position' => 'min:3',
            'media' => 'min:3',
            'media_category' => 'min:3',
            'media_department' => 'min:3',
            'type_id' => 'required|numeric',
            'external_id' => 'numeric',
        ]);

        $attendant = Attendant::create($data);
        return response()->json(['data' => ['id' => $attendant->id]]);
    }

    /**
     * @api {post} /joysail/attendants/:id Store an attendant
     * @apiName Attendants
     * @apiGroup Joysail
     *
     * @apiHeader {String} Token Auth token.
     *
     * @apiParam {String} firstname
     * @apiParam {String} lastname
     * @apiParam {String} email
     * @apiParam {String} phone
     * @apiParam {String} [position]
     * @apiParam {String} [company]
     * @apiParam {String} [media] Media sector (Outlet)
     * @apiParam {String} [media_category] Nautic / Lifestyle / General
     * @apiParam {String} [media_department] Editorial / Advertisement
     * @apiParam {Integer} type_id Get it from /joysail/attendants/types (Selection Guest/Media/Sponsors/Collab)
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     */
    public function updateAttendant(Request $request){
        $attendant = Attendant::where('external_id', $request->external_id)->first();

        if(empty($attendant)){
            return response('', 404);
        }

        $this->validate($request, [
            'firstname' => 'required|min:3',
            'lastname' => 'min:3',
            'email' => 'email|min:3',
            'phone' => 'min:3',
            'position' => 'min:3',
            'media' => 'min:3',
            'media_category' => 'min:3',
            'media_department' => 'min:3',
            'type_id' => 'required|numeric',
            'external_id' => 'numeric',
        ]);

        $data = $request->all();
        $attendant->update($data);

        return response()->json(['data' => ['id' => $attendant->id]]);
    }

    /**
     * @api {get} /joysail/attendants/types Get Attendant Types
     * @apiName Attendants
     * @apiGroup Joysail
     *
     * @apiHeader {String} Token Auth token.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *    [
     *        {
     *           "id": 1,
     *           "name": "Selection Guest"
     *        },
     *        {
     *           "id": 2,
     *           "name": "Media"
     *        },
     *        {
     *           "id": 3,
     *           "name": "Sponsors"
     *        },
     *        {
     *           "id": 4,
     *           "name": "Collaborators"
     *        }
     *    ]
     */
    public function getAttendantsTypes(){
        $data = app('db')->select("SELECT id, name FROM joysail_attendants_types");
        return response()->json($data);
    }
}
