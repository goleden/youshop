/**
 * 枚举类：支付方式
 */
module.exports = {
  BALANCE: {
    name: '余额支付',
    value: 10,
    show: false,
  },
  WECHAT: {
    name: '微信支付',
    value: 20,
    show: false,
  },
  OFFLINE: {
    name: '线下支付/货到付款',
    value: 30,
    show: true,
  },
  defaultPayType: 30,
};