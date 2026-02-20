<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'name_pl',
        'group',
        'satuan',
        'type',
        'stock',
        'photo_thumbnail',
        'summary',
        'price_hpp',
        'price',
        'price_grosir15',
        'price_grosir50',
        'price_discount',
        'is_recomended',
        'is_sold_out',
        'is_pricelist',
        'is_new',
        'status',
        'category',
        'origin',
        'elevation',
        'varietal',
        'process',
        'processor',
        'harvest',
        'desc',
        'author',
        'editor'
    ];

    public function detailSeller(){
        return $this->hasOne(SellerInfo::class, 'id', 'seller_id');
    }

    public function detailColor(){
        return $this->hasOne(RefColor::class, 'id', 'color');
    }

    public function detailOwner(){
        return $this->hasOne(RefProductOwner::class, 'id', 'owner');
    }
    
    public function detailBrand(){
        return $this->hasOne(RefBrand::class, 'id', 'brand');
    }
    
    public function detailType(){
        return $this->hasOne(ProductType::class, 'id', 'type');
    }
    
    public function detailVariant(){
        return $this->hasOne(RefVariant::class, 'id', 'variant');
    }
    
    public function detailBodyType(){
        return $this->hasOne(RefSatuan::class, 'id', 'body_type');
    }
    
    public function detailVehicleCode(){
        return $this->hasOne(RefVehiclesCode::class, 'id', 'vehicles_code');
    }
    
    public function detailMachineCapacity(){
        return $this->hasOne(RefMachineCapacity::class, 'id', 'machine_capacity');
    }
    
    public function detailKm(){
        return $this->hasOne(RefMileage::class, 'id', 'mileage');
    }

    public function detailAuthor(){
        return $this->hasOne(User::class, 'id', 'author');
    }

    public function detailEtalase(){
        return $this->hasOne(Etalase::class, 'product', 'id');
    }

    public function listVisitation(){
        return $this->hasMany(Visitation::class, 'product', 'id');
    }

    public function listWaiting(){
        return $this->listVisitation()->where('status', 'Menunggu Konfirmasi');
    }
    
    public function listApproved(){
        return $this->listVisitation()->where('status', 'Disetujui');
    }
    
    public function listRejected(){
        return $this->listVisitation()->where('status', 'Ditolak');
    }

    //query data
    public function queryVisitionWaitingConfirmation(){
        return DB::table('product AS p')
            ->select(DB::raw('DISTINCT p.id'), 'p.*', 'p.id AS product_id', 'p.created_at AS created_date')
            ->join('visitation AS vt', 'vt.product', '=', 'p.id')
            ->where('vt.status', 'Menunggu Konfirmasi');
    }
    
    public function queryVisitationApproved(){
        return DB::table('product AS p')
            ->select(DB::raw('DISTINCT p.id'), 'p.*', 'p.id AS product_id', 'p.created_at AS created_date')
            ->join('visitation AS vt', 'vt.product', '=', 'p.id')
            ->where('vt.status', 'Disetujui');
    }
    
    public function queryVisitationRejected(){
        return DB::table('product AS p')
            ->select(DB::raw('DISTINCT p.id'), 'p.*', 'p.id AS product_id', 'p.created_at AS created_date')
            ->join('visitation AS vt', 'vt.product', '=', 'p.id')
            ->where('vt.status', 'Ditolak');
    }

}
