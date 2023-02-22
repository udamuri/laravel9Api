<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Tambahkan Carbon

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'desc',
        'is_active',
        'is_delete',
    ];

	#START Tambahkan Default Setup Model

	/**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
		'formattedCreatedAt',
        'formattedUpdatedAt',
    ];

	/** membuat default format tanggal create */
	public function getFormattedCreatedAtAttribute($value)
    {
        return Carbon::parse($this->created_at)->format('d M Y H:i:s');
    }
    
	/** membuat default format tanggal update */
    public function getFormattedUpdatedAtAttribute($value)
    {
        return Carbon::parse($this->updated_at)->format('d M Y H:i:s');
    }

	/**
	 * name : sesuai yang di tabel
	 * desc : sesuai yang di tabel
	 */
	public function scopeWhereSearch($query, $search)
    {
        foreach (explode(' ', $search) as $term) {
            $query->where('categories.name', 'LIKE', '%'.$term.'%')
                ->orWhere('categories.desc', 'LIKE', '%'.$term.'%');
        }
    }
    
    public function scopeApplyFilters($query, array $filters)
    {
        $filters = collect($filters);
        if ($filters->get('search')) {
            $query->whereSearch($filters->get('search'));
        }
    }

	public function scopePaginateData($query, $limit)
    {
        if ($limit == 'all') {
            return collect(['data' => $query->get()]);
        }

        return $query->paginate($limit);
    }

	public static function createModel($request) {        
        $data = $request;
        $model = self::create($data);

        return $model;
    }

    public function updateModel($request) {
        $data = $request;
        $model = $this->update($data);

        return $model;
    }
	
	#END Tambahkan Default Setup Model

}
