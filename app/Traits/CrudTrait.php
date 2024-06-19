<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait CrudTrait
{
    public function create($data)
    {
        return $this->getModel()->create($data);
    }

    public function read($id)
    {
        return $this->getModel()->findOrFail($id);
    }

    public function update($id, $data)
    {
        $record = $this->read($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->read($id);
        return $record->delete();
    }

    public function getAll()
    {
        return $this->getModel()->all();
    }

    public function getBy($field, $value)
    {
        return $this->getModel()->where($field, $value)->get();
    }

    public function getByMultiple($fields, $values)
    {
        $query = $this->getModel();
        foreach ($fields as $key => $field) {
            $query = $query->where($field, $values[$key]);
        }
        return $query->get();
    }

    public function getByOr($field, $value)
    {
        return $this->getModel()->orWhere($field, $value)->get();
    }

    public function getByOrMultiple($fields, $values)
    {
        $query = $this->getModel();
        foreach ($fields as $key => $field) {
            $query = $query->orWhere($field, $values[$key]);
        }
        return $query->get();
    }

    public function getAllWithRelations($relations)
    {
        return $this->getModel()->with($relations)->get();
    }

    public function getAllWithRelationsAndPaginate($relations, $perPage)
    {
        return $this->getModel()->with($relations)->paginate($perPage);
    }

    public function getAllWithRelationsAndPaginateBy($relations, $perPage, $field, $value)
    {
        return $this->getModel()->with($relations)->where($field, $value)->paginate($perPage);
    }

    public function getAllWithRelationsAndPaginateByMultiple($relations, $perPage, $fields, $values)
    {
        $query = $this->getModel();
        foreach ($fields as $key => $field) {
            $query = $query->where($field, $values[$key]);
        }
        return $query->with($relations)->paginate($perPage);
    }

    public function getByWhere($field, $value)
    {
        return $this->getModel()->where($field, $value)->first();
    }

    public function getOneWithRelation()
    {
        return $this->getModel()->with('relation')->first();
    }

    protected function getModel()
    {
        // Replace 'YourModel' with your actual model class name
        return new Model();
    }
}
