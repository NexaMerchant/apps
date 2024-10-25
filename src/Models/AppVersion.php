<?php
namespace NexaMerchant\Apps\Models;

use Illuminate\Database\Eloquent\Model;

class AppVersion extends Model {
    protected $table = 'apps_version';
    protected $fillable = [
        'version',
        'description',
        'app_id',
        'status',
    ];
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    public function app() {
        return $this->belongsTo(App::class, 'app_id');
    }
    public function scopeEnable($query) {
        return $query->where('status', 'enable');
    }
    public function scopeDisable($query) {
        return $query->where('status', 'disable');
    }
    public function scopePending($query) {
        return $query->where('status', 'pending');
    }
    public function scopeApp($query, $app_id) {
        return $query->where('app_id', $app_id);
    }
    public function scopeVersion($query, $version) {
        return $query->where('version', $version);
    }
    public function scopeLatest($query) {
        return $query->orderBy('created_at', 'desc');
    }
    public function scopeOldest($query) {
        return $query->orderBy('created_at', 'asc');
    }
    public function scopeNewer($query, $date) {
        return $query->where('created_at', '>', $date);
    }
    public function scopeOlder($query, $date) {
        return $query->where('created_at', '<', $date);
    }
    public function scopeBetween($query, $start, $end) {
        return $query->whereBetween('created_at', [$start, $end]);
    }
    public function scopeNotBetween($query, $start, $end) {
        return $query->whereNotBetween('created_at', [$start, $end]);
    }
    public function scopeIn($query, $array) {
        return $query->whereIn('id', $array);
    }
    public function scopeNotIn($query, $array) {
        return $query->whereNotIn('id', $array);
    }
    public function scopeLike($query, $field, $value) {
        return $query->where($field, 'like', "%$value%");
    }

    // app version set online
    public function setOnline() {
        $this->status = 'enable';
        $this->save();
    }

    // app version set offline
    public function setOffline() {
        $this->status = 'disable';
        $this->save();
    }

}