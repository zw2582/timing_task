<?php
namespace app\modules\supplier_v1\models;

use yii\base\Model;

use app\models\SRegularDiscount;
use app\models\SProBdetail;
use app\models\SProBiology;

/**
 * 化学品表单
 * @author wei.w.zhou.integle.com
 * @copyright 2016-7-21下午3:29:46
 */
class BiologyDiscountPrice extends Model {

    
    /*

     * 
     * 按照供应商 产品ID更新规则折扣价格
     * 触发条件：化学品新增或者修改触发
     * 
     *      */
    static function saveDiscountPriceById($supplierId,$product) {
        //查询供应商设置的折扣
        $time=time();
        //找出当前供应商有效的针对用户的折扣规则
        $sqlRegular = "select * from  integle_s_regular_discount "
                . "where status=1 and supplier_id=".$supplierId." "
                . "and target=1 " //排除鹰群折扣
                . "and start_time<".$time." and (end_time>".$time." or end_time=0) ";
        $command = \Yii::$app->db->createCommand($sqlRegular);
        $SRegularDiscountList=$command->queryAll();
        
        //初始化该供应商的产品的折扣信息
        $sqlCdetail = "UPDATE integle_s_pro_bdetail t,integle_s_pro_biology t1  "
                . "SET t.regular_rate = 100, t.regular_id = 0, t.regular_price = t.price  , t.begin_time = 0,  t.end_time = 0 , t.update_time=".time()." "
                . " WHERE t1.id = t.bio_id AND t1.supplier_id = ".$supplierId." AND t1.status = 1 and t.bio_id=".$product->id." ";
        
        $command = \Yii::$app->db->createCommand($sqlCdetail);
        $command->execute();
  
        //按照从低到高的折扣规则 批量更新商品        
        if($SRegularDiscountList)
        {
            foreach($SRegularDiscountList as $key=>$value)
            {
                //找出规则
                
                $regular=json_decode($value['regular'],true); 
                //只有品类为1或者0时才走规则
                if(2==$regular['pro_type'] or 0==$regular['pro_type'])
                {
                    if(1==$value['type']) {
                    $sqlDiscountPrice="UPDATE integle_s_pro_bdetail t,integle_s_pro_biology t1   "
                            . "SET t.regular_rate = ".$value['rate'].", "
                            . "t.regular_id = ".$value['id'].","
                            . " t.regular_price = price*".$value['rate']."/100, "
                            . "t.begin_time = ".$value['start_time'].",  "
                            . "t.end_time = ".$value['end_time'].", "
                            . "t.update_time = ".time()." "
                            . " WHERE t1.id = t.bio_id AND t1.supplier_id = ".$supplierId." AND t1.status = 1  and t.bio_id=".$product->id."";
                            if($regular['brand']){
                               $sqlDiscountPrice.=" and t1.brand='".$regular['brand']."' ";
                            }
                            if($regular['promotion']){
                               $sqlDiscountPrice.=" and t.promotion=".$regular['promotion']." ";
                            }
                            /*if($regular['promotion_tag_id']){
                               $sqlDiscountPrice.=" and t.promotion_tag_id=".$regular['promotion_tag_id']." ";
                            }*/
                            if($regular['number']){
                               $sqlDiscountPrice.=" and t1.number='".$regular['number']."' ";
                            }
                            $sqlDiscountPrice.= " and (regular_price=0 or regular_price>price*".$value['rate']."/100) ";   

                     }
                    else {
                        $sqlDiscountPrice="UPDATE integle_s_pro_bdetail t,integle_s_pro_biology t1   "
                            . "SET t.regular_rate = ".$value['rate'].", "
                            . "t.regular_id = ".$value['id'].","
                            . " t.regular_price = ".$value['price'].", "
                            . "t.begin_time = ".$value['start_time'].",  "
                            . "t.end_time = ".$value['end_time'].", "
                            . "t.update_time = ".time()." "
                            . " WHERE t1.id = t.bio_id AND t1.supplier_id = ".$supplierId." AND t1.status = 1  and t.bio_id=".$product->id." ";
                            if($regular['brand']){
                               $sqlDiscountPrice.=" and t1.brand='".$regular['brand']."' ";
                            }
                            if($regular['promotion']){
                               $sqlDiscountPrice.=" and t.promotion=".$regular['promotion']." ";
                            }
                            /*if($regular['promotion_tag_id']){
                               $sqlDiscountPrice.=" and t.promotion_tag_id=".$regular['promotion_tag_id']." ";
                            }*/
                            if($regular['number']){
                               $sqlDiscountPrice.=" and t1.number='".$regular['number']."' ";
                            }
                            $sqlDiscountPrice.="and (regular_price=0 or regular_price>".$value['price'].")";
                    }
                }
                //echo $sql;
                $command = \Yii::$app->db->createCommand($sqlDiscountPrice);
                $command->execute();
               
            }
            return TRUE;
        }
        else
        {
            //无需处理
            return TRUE;
        }
    }
    /*

     * 
     * 按照供应商更新规则折扣价格
     * 
     *      */
    static function saveDiscountPriceBySupplier($supplierId) {
        //查询供应商设置的折扣
        $time=time();
        
        $sqlRegular = "select * from  integle_s_regular_discount "
                . "where status=1 and supplier_id=".$supplierId." "
                . "and start_time<".$time." and (end_time>".$time." or end_time=0) ";
        $command = \Yii::$app->db->createCommand($sqlRegular);
        $SRegularDiscountList=$command->queryAll();
        
        //初始化该供应商的产品的折扣信息
        $sqlBdetail = "UPDATE integle_s_pro_bdetail t,integle_s_pro_biology t1  "
                . "SET t.regular_rate = 100, t.regular_id = 0, t.regular_price = t.price, t.begin_time = 0,  t.end_time = 0 ,t.update_time=".time()." "
                . " WHERE t1.id = t.bio_id AND t1.supplier_id = ".$supplierId." AND t1.status = 1 ";
        
        $command = \Yii::$app->db->createCommand($sqlBdetail);
        $command->execute();
  
        //按照从低到高的折扣规则 批量更新商品        
        if($SRegularDiscountList)
        {
            foreach($SRegularDiscountList as $key=>$value)
            {
                //找出规则
                
                $regular=json_decode($value['regular'],true); 
                //只有品类为1或者0时才走规则
                if(2==$regular['pro_type'] or 0==$regular['pro_type'])
                {
                    if(1==$value['type']) {
                    $sqlDiscountPrice="UPDATE integle_s_pro_bdetail t,integle_s_pro_biology t1  "
                            . "SET t.regular_rate = ".$value['rate'].", "
                            . "t.regular_id = ".$value['id'].","
                            . " t.regular_price = price*".$value['rate']."/100, "
                            . "t.begin_time = ".$value['start_time'].",  "
                            . "t.end_time = ".$value['end_time'].", "
                            . "t.update_time = ".time()." "
                            . " WHERE t1.id = t.bio_id AND t1.supplier_id = ".$supplierId." AND t1.status = 1 ";
                            if($regular['brand']){
                               $sqlDiscountPrice.=" and t1.brand='".$regular['brand']."' ";
                            }
                            if($regular['promotion']){
                               $sqlDiscountPrice.=" and t.promotion=".$regular['promotion']." ";
                            }
                            /*if($regular['promotion_tag_id']){
                               $sqlDiscountPrice.=" and t.promotion_tag_id=".$regular['promotion_tag_id']." ";
                            }*/
                            if($regular['number']){
                               $sqlDiscountPrice.=" and t1.number='".$regular['number']."' ";
                            }
                            $sqlDiscountPrice.= " and (regular_price=0 or regular_price>price*".$value['rate']."/100) ";   

                     }
                    else {
                        $sqlDiscountPrice="UPDATE integle_s_pro_bdetail t,integle_s_pro_biology t1  "
                            . "SET t.regular_rate = ".$value['rate'].", "
                            . "t.regular_id = ".$value['id'].","
                            . " t.regular_price = ".$value['price'].", "
                            . "t.begin_time = ".$value['start_time'].",  "
                            . "t.end_time = ".$value['end_time'].", "
                            . "t.update_time = ".time()." "
                            . " WHERE t1.id = t.bio_id AND t1.supplier_id = ".$supplierId." AND t1.status = 1 ";
                            if($regular['brand']){
                               $sqlDiscountPrice.=" and t1.brand='".$regular['brand']."' ";
                            }
                            if($regular['promotion']){
                               $sqlDiscountPrice.=" and t.promotion=".$regular['promotion']." ";
                            }
                            if($regular['promotion_tag_id']){
                               $sqlDiscountPrice.=" and t.promotion_tag_id=".$regular['promotion_tag_id']." ";
                            }
                            if($regular['number']){
                               $sqlDiscountPrice.=" and t1.number='".$regular['number']."' ";
                            }
                            $sqlDiscountPrice.="and (regular_price=0 or regular_price>".$value['price'].")";
                    }
                }
                //echo $sql;
                $command = \Yii::$app->db->createCommand($sqlDiscountPrice);
                $command->execute();
               
            }
            return TRUE;
        }
        else
        {
            //无需处理
            return TRUE;
        }
    }
    
}