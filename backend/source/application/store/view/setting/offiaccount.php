<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">微信公众号设置</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require"> AppID </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="offiaccount[AppID]"
                                           value="<?= $values['AppID'] ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require"> AppSecret </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="offiaccount[AppSecret]"
                                           value="<?= $values['AppSecret'] ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require"> Token </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="offiaccount[Token]"
                                           value="<?= $values['Token'] ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">订单提醒</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    是否开启提醒
                                </label>
                                <div class="am-u-sm-9">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="offiaccount[order_pay][is_enable]" value="1"
                                               data-am-ucheck
                                            <?= isset($values['order_pay']['is_enable']) && $values['order_pay']['is_enable'] == '1' ? 'checked' : '' ?>
                                               required>
                                        开启
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="offiaccount[order_pay][is_enable]" value="0"
                                               data-am-ucheck
                                            <?= isset($values['order_pay']['is_enable']) && $values['order_pay']['is_enable'] == '0' ? 'checked' : '' ?>>
                                        关闭
                                    </label>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    模板消息ID <span class="tpl-form-line-small-title">Template ID</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="offiaccount[order_pay][template_id]"
                                           value="<?= $values['order_pay']['template_id'] ?? '' ?>">
                                    <small>例如：模板编号AT0009，关键词 (订单编号、支付时间、订单金额、商品名称)</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require"> 绑定管理员微信 </label>
                                <div class="am-u-sm-9">
                                    <img style="width: 200px;" src="<?= $wechatManager['qrcode'] ?>">
                                    <small>当前管理员："<?= $wechatManager['userInfo']['nickname'] ?? '暂未绑定管理员微信' ?>"</small>
                                    <div class="help-block">
                                        <small>注：请用管理员的微信扫码绑定，系统收到订单将通过微信公众号通知。10分钟内扫码有效，否则刷新页面重新获取。</small>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-secondary">提交
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();
    });
</script>
