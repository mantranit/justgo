/**
 * Created by ManTran on 7/15/2015.
 */
$(function(){
    $('.money-input').maskMoney({
        thousands:'.',
        decimal:',',
        precision: 0,
        allowZero:true,
        suffix: 'đ'
    });
});