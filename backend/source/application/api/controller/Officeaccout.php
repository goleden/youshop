<?php

namespace app\api\controller;

use app\api\model\Setting as SettingModel;
use app\common\enum\Setting as SettingEnum;
use think\Log;
use think\Controller;

/**
 * 微信公众号接口
 * @package app\task\controller
 */
class Officeaccout extends Controller
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
        $this->app = \EasyWeChat\Factory::officialAccount(SettingModel::getEasywechatOfficialAccountConfig());
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
            Log::info($message);
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
        if (empty($scene)) {
            return '';
        }

        if ($scene == SettingEnum::OFFIACCOUT) {
            // 更新管理员openid
            $config = SettingModel::getItem(SettingEnum::OFFIACCOUT);
            $config['order_pay']['openid'] = $this->openid;
            $model = new SettingModel();
            $model->updateOffiaccount($config);
            return '管理员绑定成功，系统收到订单将会通知您。';
        }
    }

    /**
     * 自定义菜单
     *
     * @return void
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

    // public function test()
    // {
    //     $message = new \app\common\service\Message();

    //     $order = \app\common\model\Order::detail('10001');
    //     $message->sendOffiaccountTemplateMessage($order);
    // }
}
