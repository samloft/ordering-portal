<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Models\Contacts
 *
 * @mixin Eloquent
 */
class Contacts extends Model
{
    protected $table = 'contact';

    /**
     * @return Collection
     */
    public static function show()
    {
        return (new Contacts)->orderBy('name', 'desc')->get();
    }

    /**
     * @param $contact
     * @return bool
     */
    public static function store($contact)
    {
        return (new Contacts)->insert($contact);
    }

    /**
     * @param $id
     * @param $contact
     * @return int
     */
    public static function edit($id, $contact)
    {
        return (new Contacts)->where('id', $id)->update($contact);
    }

    /**
     * @param array|Collection|int $id
     * @return int|mixed
     */
    public static function destroy($id)
    {
        return (new Contacts)->where('id', $id)->delete();
    }
}
