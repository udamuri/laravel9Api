<?php

namespace App\Http\Controllers\Api\V1\Product;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
			$limit = (int) $request->query('per_page', 15);

            $model = Category::applyFilters($request->only([
						'search',
					]))
					->paginateData($limit);
            
            $paginate = [
                'total' => (int) $model->total(),
                'currentPage' => (int) $model->currentPage(),
                'lastPage' => (int) $model->lastPage(),
                'hasMorePages' => (boolean) $model->hasMorePages(),
                'perPage' => (int) $model->perPage(),
                'total' => (int) $model->total(),
                'lastItem' => (int) $model->lastItem(),
            ];

            $success = api_format(true, [], $model->items(), $paginate);
            return response()->json($success, 200);
        } catch (\Exception $ex) {
            $error = api_format(false, [["message" => [$ex->getMessage()]]], [], []);
            return response()->json($error, 200);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
				'name' => 'required|string|max:100',
				'desc' => 'required|string|max:255',
				'is_active' => 'nullable|in:0,1',
            ])->setAttributeNames([
                'name' => 'Kategori',
                'desc' => 'Keterangan',
                'is_active' => 'Status',
            ]);
            
            if ($validator->fails()) {
                $error = api_format(false, [$validator->errors()->toArray()], [], []);
                return response()->json($error, 200);
            } else {
                Category::createModel($request->only(['name', 'desc', 'is_active']));

                $success = api_format(true, [["msg" => [Lang::get('messages.message_create', ['attribute' => "Kategori"])]]], [], []);
		
				return response()->json($success, 200);
            }
        } catch (\Exception $ex) {
            $error = api_format(false, [["message" => [$ex->getMessage()]]], [], []);
            return response()->json($error, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        try {
            $validator = Validator::make($request->all(), [
				'name' => 'required|string|max:100',
				'desc' => 'required|string|max:255',
				'is_active' => 'nullable|in:0,1',
            ])->setAttributeNames([
                'name' => 'Kategori',
                'desc' => 'Keterangan',
                'is_active' => 'Status',
            ]);
            
            if ($validator->fails()) {
                $error = api_format(false, [$validator->errors()->toArray()], [], []);
                return response()->json($error, 200);
            } else {
                $category->updateModel($request->only(['name', 'desc', 'is_active']));

                $success = api_format(true, [["msg" => [Lang::get('messages.message_update', ['attribute' => "Kategori"])]]], [], []);
				return $success;
            }
        } catch (\Exception $ex) {
            $error = api_format(false, [["message" => [$ex->getMessage()]]], [], []);
            return response()->json($error, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
