<?php
class Source_Product_ProductFlat extends \Eloquent
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table='product_flat';
    public  $timestamps = false;

    /**
     * ----------------------------------
     *  一对一关联产品flat表关联flatdetail表
     * ----------------------------------
     */
    public function productFlatToFlatDetail()
    {
        return $this->belongsTo( 'Source_Product_ProductFlatDetail', 'entity_id', 'entity_id' );
    }

    /**
     * ----------------------------------
     *  一对一关联产品库存表
     * ----------------------------------
     */
    public function productFlatToStock()
    {
        return $this->belongsTo( 'Source_Product_ProductEntityStock', 'entity_id', 'entity_id' );
    }

    /**
     * ----------------------------------
     *  一对一关联供应商
     * ----------------------------------
     */
    public function productFlatToSupplier()
    {
        return $this->belongsTo( 'Source_Product_ProductEntitySupplier', 'entity_id', 'entity_id' );
    }

    /**
     * ----------------------------------
     *  一对一关联分类表
     * ----------------------------------
     */
    public function productFlatToCategory()
    {
        return $this->belongsTo( 'Source_Product_ProductCategory', 'category_id', 'id' );
    }

    /**
     * @return mixed
     * 关联到商品属性集
     */
    public function productAttbuteSet()
    {
        return $this->belongsTo( 'Source_Eav_AttrbuteSet', 'attribute_set_id', 'id' );
    }


    /**
     *  一对一关联店铺表
     */
    public function productToShop()
    {
        return $this->belongsTo( 'Source_User_ShopInfo', 'shop', 'id' );
    }

}