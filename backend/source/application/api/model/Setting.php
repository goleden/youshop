<?php

namespace app\api\model;

use think\Cache;
use app\common\model\Setting as SettingModel;
use app\common\enum\Setting as SettingEnum;

/**
 * 系统设置模型
 * Class Setting
 * @package app\api\model
 */
class Setting extends SettingModel
{
    /**
     * 更新公众号管理员设置
     * @param $values
     * @return bool
     * @throws \think\exception\DbException
     */
    public function updateOffiaccount($values)
    {
        $key = SettingEnum::OFFIACCOUT;
        $model = self::detail($key) ?: $this;
        // 删除系统设置缓存
        Cache::rm('setting_' . self::$wxapp_id);
        return $model->save([
                'key' => $key,
                'describe' => SettingEnum::data()[$key]['describe'],
                'values' => $values,
                'wxapp_id' => self::$wxapp_id,
            ]) !== false;
    }
}
