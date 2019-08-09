<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * 与模型关联的表名
     * @var string
     */
    protected $table = 'user';

    // 设置主键id
    protected $primaryKey = "uid";

    /**
     * 指示模型是否自动维护时间戳
     * @var bool
     */
    public $timestamps = false;

    /**
     * 模型的连接名称
     *
     * @var string
     */
    protected $connection = 'mysqldemo';
}
