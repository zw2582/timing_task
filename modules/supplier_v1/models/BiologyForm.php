<?php
namespace app\modules\supplier_v1\models;

use app\models\SProBdetail;
use app\models\SProBiology;
use app\models\SPromotionTag;
use app\modules\supplier_v1\models\BiologyDiscountPrice;
use app\modules\supplier_v1\models\SProBiologyModel;
use yii\base\Model;
/**
 * 生物试剂表单
 * @author zhouwei<wei.w.zhou@integle.com>
 * @copyright 2016-6-25 上午11:50:36
 */
class BiologyForm extends Model {
    
    /**
     * 修改或新增
     * @author wei.w.zhou.integle.com
     * @param unknown $userId
     * @param unknown $param
     * @return boolean
     * @copyright 2016-6-23上午11:58:23
     */
    public function save($userId, $supplierId, $param, $missionId) {
        //启动事务
        $transaction = SProBiology::getDb()->beginTransaction();
        //1.新增产品
        $product = SProBiologyModel::findOne(['number'=>$param['number'], 'supplier_id'=>$supplierId, 'status'=>1]);
        if (empty($product)) {
            $product = new SProBiologyModel();
        }
        $product->attributes = $param;
        $product->user_id = $userId;
        $product->supplier_id = $supplierId;
        $product->mission_id = $missionId;
        if (!$product->save()) {
            $transaction->rollBack();
            $this->addError('save', current($product->getFirstErrors()));
            return FALSE;
        }
        //2.新增详情
        $detail = SProBdetail::findOne([
            'bio_id'=>$product->id, 
            'package'=>$param['package'],
            'status'=>1
        ]);
        if (empty($detail)) {
            $detail = new SProBdetail(['bio_id'=>$product->id]);
        }
        
        
        
        //新增promotion_tag_id
        if (!empty($param['promotion_tag'])) {
            $promotionTag = SPromotionTag::findOne([
                'tag' => $param['promotion_tag'],
                'pro_type' => 2,
                'supplier_id' => $supplierId
            ]);
            if (empty($promotionTag)) {
                $promotionTag = new SPromotionTag();
                $promotionTag->supplier_id = $supplierId;
                $promotionTag->pro_type = 2;
                $promotionTag->tag = $param['promotion_tag'];
                if (!$promotionTag->save()) {
                    $this->addErrors($promotionTag->getErrors());
                    return FALSE;
                }
            }
            $param['promotion_tag_id'] = $promotionTag['id'];
        }
        
        
        
        $detail->attributes = $param;
        if (!$detail->save()) {
            $transaction->rollBack();
            $this->addError('save', current($detail->getFirstErrors()));
            return FALSE;
        }
        
        //3 更新折后价
        $result=  BiologyDiscountPrice::saveDiscountPriceByID($supplierId,$product);
        if(!$result)
        {
            $transaction->rollBack();
            $this->addError('detail', current($result->getFirstErrors()));
            return FALSE;
        }
        $transaction->commit();
        return TRUE;
    }
}