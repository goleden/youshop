<?php

namespace app\task\controller;

use app\store\model\Setting as SettingModel;

/**
 * 微信公众号接口
 * @package app\task\controller
 */
class Officeaccout
{
    protected $message;
    protected $openid;
    protected $subscribeScene; // 关注二维码scene
    /**
     * @var \EasyWeChat\OfficialAccount\Application
     */
    protected $app;

    public function _initialize()
    {
        $config    = (new \Common\Library\Config())->easyWechatOfficialAccount();
        $this->app = \EasyWeChat\Factory::officialAccount($config);
    }

    /**
     * 获取网页授权
     */
    public function serve()
    {
        $app = $this->app;
        $app->server->push(function ($message) {
            $this->message = $message;
            $this->openid = $message['FromUserName'];
            // D('Common/DebugLog')->addLog($message, 'wechatMessage');
            switch ($message['MsgType']) {
                case 'event':
                    return $this->event();
                    break;
                case 'text':
                    return '';
                    break;
                case 'image':
                    return '';
                    break;
                case 'voice':
                    return '';
                    break;
                case 'video':
                    return '';
                    break;
                case 'location':
                    return '';
                    break;
                case 'link':
                    return '';
                    break;
                case 'file':
                    return '';
                    // ... 其它消息
                default:
                    return '';
                    break;
            }

            // ...
        });
        $response = $app->server->serve();

        // 将响应输出
        $response->send();
        exit;
    }

    protected function event()
    {
        $message = $this->message;
        switch ($message['Event']) {
                // 扫描带参数二维码事件
            case 'subscribe': // 未关注的事件
                if (!empty($message['EventKey'])) {
                    $this->subscribeScene = substr($message['EventKey'], 8);
                    return $this->subscribe();
                }
                return '';
                break;
            case 'SCAN': // 已关注的事件
                if (!empty($message['EventKey'])) {
                    $this->subscribeScene = $message['EventKey'];
                    return $this->subscribe();
                }
                return '';
                //
                break;
            default:
                return '';
                break;
        }
    }

    protected function subscribe()
    {
        if (empty($this->subscribeScene)) {
            return '';
        }
        $scene = $this->subscribeScene;
        list($key, $station_id) = explode('_', $scene);
        if (empty($key) || empty($station_id)) {
            return '';
        }

        $model = new SettingModel();
        $config = $model->where([
            'code' => $key,
            'station_id' => $station_id
        ])->fetch();
        if ($model->edit('offiaccount', $this->postData($key))) {
            return $this->renderSuccess('操作成功');
        }
        if (!empty($config)) {
            $model->where([
                'code' => $key,
                'station_id' => $station_id
            ])->setField('value', json_encode($this->openid, JSON_UNESCAPED_UNICODE));
        } else {
            $model->add([
                'code' => $key,
                'station_id' => $station_id,
                'title' => '管理员openid',
                'value' => json_encode($this->openid, JSON_UNESCAPED_UNICODE)
            ]);
        }
        return '管理员绑定成功，系统收到订单将会通知您。';
    }

    /**
     * 自定义菜单
     *
     * @return void
     * @author guoruidian
     * @date 2020-04-21
     */
    public function menu()
    {
        $app = $this->app;
        $buttons = [
            [
                "type" => "miniprogram",
                "name" => "希梵商城",
                "appid" => "wxe28067a465805491",
                "url" => "https://xf.630302.com/",
                "pagepath" => "pages/index/index"
            ],
        ];
        $app->menu->create($buttons);
    }
}
