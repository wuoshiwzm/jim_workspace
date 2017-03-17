<?php
class Product
{
    /**
     * @param $pid
     * @return mixed
     * 商品id
     */
    public function  GetProductEav($pid){

        $dec =  DB::table('product_entity_decimal')->where('entity_id',$pid);
        $int =  DB::table('product_entity_int')->where('entity_id',$pid);
        $var =  DB::table('product_entity_varchar')->where('entity_id',$pid);
        $text = DB::table('product_entity_text')->where('entity_id',$pid);
        $list = DB::table('product_entity_timestamp')->where('entity_id',$pid)
            ->union($var)->union($int)->union($dec)->union($text)
            ->get();
        return $list;
    }


    /**
     * @param $setID
     * @return array
     * 添加产品from表单
     */
    static function getProductFrom( $setID )
    {
       // 1标准2 价格，3seo,4图片 5 描述
        $result = array();
        $data = Source_Product_ProductEav::where('attbute_set_id',$setID)->orderBy('id','asc')->with('productEavToEav')->get();
        foreach ( $data as $k=>$row )
        {
            //不是可配的
            if( $row->is_fiter == 0  && $row->productEavToEav->is_hidden == 0 )
            {
                switch ( $row->group )
                {
                    case "1":
                        $arr[0]['name'] = '商品基本信息';
                        $arr[0]['value'][] = $row;
                        break;
                    case "2":
                        $arr[1]['name'] = '商品价格';
                        $arr[1]['value'][] = $row;
                        break;
                    case "3":
                        $arr[2]['name'] = '商品SEO优化';
                        $arr[2]['value'][] = $row;
                        break;
                    case "5":
                        $arr[3]['name'] = '商品描述';
                        $arr[3]['value'][] = $row;
                        break;
                }
            }
            //可配的
            if( $row->is_fiter == 1 && $row->productEavToEav->is_hidden == 0  )
            {
                $configure['name'] = '可配置';
                $configure['value'][] = $row;
            }
        }

        $result['data'] = isset($arr)?$arr:[];
        $result['configure'] = isset($configure)?$configure:[];
        return $result;
    }


    /**
     * 添加产品
     * @param $data
     * @return bool
     */
    static function addGoods( $data, $eID )
    {
        $result = DB::transaction(function() use ( $data, $eID)
        {
            //产品flat表
            $flat = array();
            //产品动态表
            $flatDetail = array();
            //配置产品数组
            $additional = array();
            //配置产品
            $attribute_json = array();
            //配置产品分类
            $attribute_ones = array();
            //添加
            foreach ( $data as $key=>$row )
            {
               $res = Source_Eav_Attrbute::find( $key );
               if( $res )
               {
                   switch ( $res->type )
                   {

                       case 'varchar':
                           $varchar['entity_id'] = $eID;
                           $varchar['attbute_id'] = $key;
                           $varchar['value'] = $row;
                           Source_Product_ProductEntityVarchar::insert( $varchar );
                           if( $res->is_system == 1 )
                           {
                               $flat[$res->name] = $row;

                           }else
                           {
                               $flatDetail[$res->name] = $row;
                           }
                           break;
                       case 'int':
                           $int['entity_id'] = $eID;
                           $int['attbute_id'] = $key;
                           $int['value'] = $row;
                           Source_Product_ProductEntityInt::insert( $int );
                           if( $res->is_system == 1 )
                           {
                               $flat[$res->name] = $row;

                           }else
                           {
                               $flatDetail[$res->name] = $row;
                           }
                           break;
                       case 'decimal':
                           $decimal['entity_id'] = $eID;
                           $decimal['attbute_id'] = $key;
                           $decimal['value'] = $row;
                           Source_Product_ProductEntityDecimal::insert( $decimal );
                           if( $res->is_system == 1 )
                           {
                               $flat[$res->name] = $row;

                           }else
                           {
                               $flatDetail[$res->name] = $row;
                           }
                           break;
                       case 'timestamp':
                           $timestamp['entity_id'] = $eID;
                           $timestamp['attbute_id'] = $key;
                           $timestamp['value'] = $row;
                           Source_Product_ProductEntityTimestamp::insert( $timestamp );
                           if( $res->is_system == 1 )
                           {
                               $flat[$res->name] = $row;

                           }else
                           {
                               $flatDetail[$res->name] = $row;
                           }
                           break;
                       case 'text':
                           $text['entity_id'] = $eID;
                           $text['attbute_id'] = $key;
                           //上传编辑器里的图片
                           $content = Product::addContentImg( $row, $eID);
                           $text['value'] = $content;
                           Source_Product_ProductEntityText::insert( $text );
                           if( $res->is_system == 1 )
                           {
                               $flat[$res->name] = $content;

                           }else
                           {
                               $flatDetail[$res->name] = $content;
                           }
                           break;
                   }
                   //配置产品检索表
                   if( $res->is_layer_search  == 1 )
                   {
                       //添加检索分类信息
                       $option = Source_Screen_CategoryOption::firstOrCreate(['attbute_id'=>$key,'category_id'=>$data['category_id']]);
                       //添加检索分类信息值
                       Source_Screen_CategoryOptionDetail::firstOrCreate(['option_id'=>$option->id,'value'=>$row,'tilte'=>$res->name]);
                   }

                   //品牌检索表
                   Source_Screen_CategoryBrand::firstOrCreate(['category_id'=>$data['category_id'],'brand_id'=>$data['brand_id']]);
               }else
               {
                   //配置产品表
                   if( is_array( $data[$key] ) )
                   {
                       $additional[$key] = $row;
                       switch ( $key )
                       {
                           case 'p':
                               break;
                           default:
                               $attribute_ones[$key] = array_values(array_unique($row));
                               break;
                       }
                   }
               }
            }
            //实体表插入
            $entity['type'] = $data['type'];
            $entity['entity_id'] = $eID;
            $entity['category_id'] = $data['category_id'];
            $entity['shop_id'] = isset($data['shop'])?$data['shop']:'';
            $entity['attribute_set_id'] = $data['attribute_set_id'];
            $entity['brand_id'] = $data['brand_id'];
            $entity['freight'] = $data['freight'];
            $entity['created_at'] = date("Y-m-d H:i:s");
            Source_Product_ProductEntity::insert( $entity );

            //供应商表插入
            $Supplier['entity_id'] = $eID;
            $Supplier['supplier_id'] = $data['supplier_id'];
            $Supplier['supplier_name'] = $data['supplier_name'];
            Source_Product_ProductEntitySupplier::insert( $Supplier );

            //库存
            $Stock['entity_id'] = $eID;
            $Stock['jingjie'] = $data['jingjie'];
            $Stock['stock'] = $data['stock'];
            Source_Product_ProductEntityStock::insert( $Stock );

            $flat['entity_id'] = $flatDetail['entity_id'] = $eID;
            //插入flat表
            $flat['supplier'] = $data['supplier_id'];
            $flat['shop'] = $data['shop'];
            $flat['kc_qty'] = $data['stock'];
            $flat['category_id'] = $data['category_id'];
            $flat['attribute_set_id'] = $data['attribute_set_id'];
            $flat['brand'] = $data['brand_id'];
            $flat['freight'] = $data['freight'];
            $flat['type'] = $data['type'];
            $flat['created_at'] = date("Y-m-d H:i:s");
            Source_Product_ProductFlat::insert( $flat );
            //插入flat扩展表
            if( count( $additional ) )
            {
                foreach ( $additional as $k=>$r )
                {
                    $keyaName[] = $k;
                    $vCount = count($r);
                }

                for ( $n=0; $n < $vCount; $n++ )
                {
                    foreach ( $keyaName as $k )
                    {
                        $attribute_json[$n][$k] = $additional[ $k ][ $n ];
                    }
                }
            }

            $jsonData[ 0 ] = $attribute_ones;
            $jsonData[ 1 ] = $attribute_json ;
            $flatDetail['attribute_json'] = json_encode( $jsonData );
            Source_Product_ProductFlatDetail::insert( $flatDetail );
            if( count($attribute_json) )
            {
                $attribute['entity_id'] = $eID;
                $attribute['value'] = $flatDetail['attribute_json'];
                Source_Product_ProductAttbuteJson::insert( $attribute );
            }

        });

        if( is_null($result) )
            return true;
        else return false;
    }



    /**
     * 编辑产品
     * @param $data
     * @return bool
     */
    static function editGoods( $data, $eID )
    {
        $result = DB::transaction(function() use ( $data, $eID)
        {
            //产品flat表
            $flat = array();
            //产品动态表
            $flatDetail = array();
            //配置产品数组
            $additional = array();
            //配置产品
            $attribute_json = array();
            //配置产品分类
            $attribute_ones = array();
            //添加
            foreach ( $data as $key=>$row )
            {
                $res = Source_Eav_Attrbute::find( $key );
                if( $res )
                {
                    switch ( $res->type )
                    {
                        case 'varchar':
                            $whereVarchar['entity_id'] = $eID;
                            $whereVarchar['attbute_id'] = $key;
                            $varchar['value'] = $row;
                            $count = Source_Product_ProductEntityVarchar::where( $whereVarchar )->count();
                            if( $count )
                            {
                                //修改
                                Source_Product_ProductEntityVarchar::where( $whereVarchar )->update( $varchar );
                            }else
                            {
                                //添加
                                $whereVarchar['value'] = $row;
                                Source_Product_ProductEntityVarchar::insert( $whereVarchar );
                            }
                            if( $res->is_system == 1 )
                            {
                                $flat[$res->name] = $row;

                            }else
                            {
                                $flatDetail[$res->name] = $row;
                            }
                            break;
                        case 'int':
                            $whereInt['entity_id'] = $eID;
                            $whereInt['attbute_id'] = $key;
                            $int['value'] = $row;
                            $count =  Source_Product_ProductEntityInt::where( $whereInt )->count();
                            if( $count )
                            {
                                //修改
                                Source_Product_ProductEntityInt::where( $whereInt )->update( $int );
                            }else
                            {
                                //添加
                                $whereInt['value'] = $row;
                                Source_Product_ProductEntityInt::insert( $whereInt );
                            }

                            if( $res->is_system == 1 )
                            {
                                $flat[$res->name] = $row;

                            }else
                            {
                                $flatDetail[$res->name] = $row;
                            }
                            break;
                        case 'decimal':
                            $whereDecimal['entity_id'] = $eID;
                            $whereDecimal['attbute_id'] = $key;
                            $decimal['value'] = $row;
                            $count =  Source_Product_ProductEntityDecimal::where( $whereDecimal )->count();
                            if( $count )
                            {
                                //修改
                                Source_Product_ProductEntityDecimal::where( $whereDecimal )->update( $decimal );
                            }else
                            {
                                //添加
                                $whereDecimal['value'] = $row;
                                Source_Product_ProductEntityDecimal::insert( $whereDecimal );
                            }
                            if( $res->is_system == 1 )
                            {
                                $flat[$res->name] = $row;

                            }else
                            {
                                $flatDetail[$res->name] = $row;
                            }
                            break;
                        case 'timestamp':
                            $whereTimestamp['entity_id'] = $eID;
                            $whereTimestamp['attbute_id'] = $key;
                            $timestamp['value'] = $row;
                            $count =  Source_Product_ProductEntityTimestamp::where( $whereTimestamp )->count();
                            if( $count )
                            {
                                //修改
                                Source_Product_ProductEntityTimestamp::where( $whereTimestamp )->update( $timestamp );
                            }else
                            {
                                //添加
                                $whereTimestamp['value'] = $row;
                                Source_Product_ProductEntityTimestamp::insert( $whereTimestamp );
                            }

                            if( $res->is_system == 1 )
                            {
                                $flat[$res->name] = $row;

                            }else
                            {
                                $flatDetail[$res->name] = $row;
                            }
                            break;
                        case 'text':
                            $whereText['entity_id'] = $eID;
                            $whereText['attbute_id'] = $key;
                            //上传编辑器里的图片
                            $content = Product::addContentImg( $row, $eID);
                            $text['value'] = $content;
                            $count =  Source_Product_ProductEntityText::where( $whereText )->count();
                            if( $count )
                            {
                                //修改
                                Source_Product_ProductEntityText::where( $whereText )->update( $text );
                            }else
                            {
                                //添加
                                $whereText['value'] = $content;
                                Source_Product_ProductEntityText::insert( $whereText );
                            }

                            if( $res->is_system == 1 )
                            {
                                $flat[$res->name] = $content;

                            }else
                            {
                                $flatDetail[$res->name] = $content;
                            }
                            break;
                    }
                    //配置产品检索表
                    if( $res->is_layer_search  == 1 )
                    {
                        //添加检索分类信息
                        $option = Source_Screen_CategoryOption::firstOrCreate(['attbute_id'=>$key,'category_id'=>$data['category_id']]);
                        //添加检索分类信息值
                        Source_Screen_CategoryOptionDetail::firstOrCreate(['option_id'=>$option->id,'value'=>$row,'tilte'=>$res->name]);
                    }

                    //品牌检索表
                    Source_Screen_CategoryBrand::firstOrCreate(['category_id'=>$data['category_id'],'brand_id'=>$data['brand_id']]);
                }else
                {
                    //配置产品表
                    if( is_array( $data[$key] ) )
                    {
                        $additional[$key] = $row;
                        switch ( $key )
                        {
                            case 'p':
                                break;
                            default:
                            $attribute_ones[$key] = array_values(array_unique($row));
                                break;
                        }
                    }
                }
            }
            //dd($additional);
            //实体表插入
            $entity['shop_id'] = isset($data['shop'])?$data['shop']:'';
            $entity['brand_id'] = $data['brand_id'];
            $entity['freight'] = $data['freight'];
            $entity['type'] = $data['type'];
            Source_Product_ProductEntity::where( 'entity_id', $eID )->update( $entity );

            //供应商表插入
            $Supplier['supplier_id'] = $data['supplier_id'];
            $Supplier['supplier_name'] = $data['supplier_name'];
            Source_Product_ProductEntitySupplier::where( 'entity_id', $eID )->update( $Supplier );

            //库存
            $Stock['jingjie'] = $data['jingjie'];
            $Stock['stock'] = $data['stock'];
            Source_Product_ProductEntityStock::where( 'entity_id', $eID )->update( $Stock );

            //插入flat表
            $flat['supplier'] = $data['supplier_id'];
            $flat['shop'] = $data['shop'];
            $flat['kc_qty'] = $data['stock'];
            $flat['brand'] = $data['brand_id'];
            $flat['freight'] = $data['freight'];
            $flat['type'] = $data['type'];
            Source_Product_ProductFlat::where( 'entity_id', $eID )->update( $flat );
            //编辑flat扩展表
            if( count( $additional ) )
            {
                foreach ( $additional as $k=>$r )
                {
                    $keyaName[] = $k;
                    $vCount = count($r);
                }

                for ( $n=0; $n < $vCount; $n++ )
                {
                    foreach ( $keyaName as $k )
                    {
                        $attribute_json[$n][$k] = $additional[ $k ][ $n ];
                    }
                }
            }
            $jsonData[0] = $attribute_ones;
            $jsonData[1] = $attribute_json;
            $flatDetail['attribute_json'] = json_encode( $jsonData );
            Source_Product_ProductFlatDetail::where( 'entity_id', $eID )->update( $flatDetail );
            if( count($attribute_json) )
            {
                $attribute['value'] = $flatDetail['attribute_json'];
                $aObj = Source_Product_ProductAttbuteJson::where( 'entity_id', $eID )->first();
                if( $aObj )
                {
                    Source_Product_ProductAttbuteJson::where( 'entity_id', $eID )->update( $attribute );
                }else
                {
                    $attribute['entity_id'] = $eID;
                    Source_Product_ProductAttbuteJson::insert( $attribute );
                }

            }else
            {
                Source_Product_ProductAttbuteJson::where( 'entity_id', $eID )->delete();
            }

        });

        if( is_null($result) )
            return true;
        else return false;
    }

    /**
     * 添加产品图片
     * @param $data
     * @return bool
     */
    static function addImg( $data )
    {
        $result = DB::transaction(function() use ( $data ) {
            $path = $data['value'];
            $entityID = $data['entityID'];
            $oldPath = $data['oldvalue'];
            $sort = $data['sort'];
            $ID = $data['id'];
            $small_image = '';
            foreach ( $path as $key=>$row )
            {
                //添加
                if( $row != '' && $ID[$key] == '' )
                {
                    $img['entity_id'] = $entityID;
                    $img['value'] = $row;
                    $img['sort'] = $sort[$key];
                    Source_Product_ProductImage::insert( $img );
                    //上传省略图片
                    Product::saveGoodsImg( $entityID, 'goods', $row );
                    if( $data['default'][$key] == '1' )
                    {
                        $small_image = $row;
                    }
                }

                //删除
                if( $ID[$key] != '' && $row == ''  )
                {
                    //删除缩略图片
                    Product::delGoodsImg( $entityID, 'goods', $oldPath[$key] );
                    Source_Product_ProductImage::where('id',$ID[$key])->delete();
                }

                //修改
                if(  $row != '' && $ID[$key] != '' )
                {
                    Source_Product_ProductImage::where('id',$ID[$key])->update(['value'=>$row,'sort'=>$sort[$key]]);
                    if( $oldPath[$key] != $row )
                    {
                        //上传省略图片
                        Product::saveGoodsImg( $entityID, 'goods', $row );
                        //删除缩略图片
                        Product::delGoodsImg( $entityID, 'goods', $oldPath[$key] );
                    }

                    if( $data['default'][$key] == '1' )
                    {
                        $small_image = $row;
                    }
                }
            }
             if( $small_image == false && count($path) )
             {
                 $small_image = $path[0];
             }
             Source_Product_ProductFlat::where('entity_id',$entityID)->update(['small_image'=>$small_image]);
        });

        if ( is_null($result) )
        {
            return true;
        }else
        {
            return false;
        }
    }

    /**
     * @param $entity_id
     * @return mixed
     * 通过entity_id 获取商品信息
     */
    static function getProductById( $entity_id )
    {
        return Source_Product_ProductFlat::where('entity_id',$entity_id)->first();
    }


    /**
     * 删除产品
     * @param $id
     * @return bool
     */
    static function delGoods( $id )
    {
        if( $id )
        {
            $result = DB::transaction(function() use ( $id ) {
                //删除实体表
                Source_Product_ProductFlat::where( 'entity_id', $id )->delete();
                //删除附表
                Source_Product_ProductFlatDetail::where( 'entity_id', $id )->delete();
                //删除图片表
                Source_Product_ProductImage::where( 'entity_id', $id )->delete();
                //删除eav实体
                Source_Product_ProductEntity::where( 'entity_id', $id )->delete();
                //删除varchar表
                Source_Product_ProductEntityVarchar::where( 'entity_id', $id )->delete();
                //删除int表
                Source_Product_ProductEntityInt::where( 'entity_id', $id )->delete();
                //删除decimal表
                Source_Product_ProductEntityDecimal::where( 'entity_id', $id )->delete();
                //删除timestamp表
                Source_Product_ProductEntityTimestamp::where( 'entity_id', $id )->delete();
                //删除text表
                Source_Product_ProductEntityText::where( 'entity_id', $id )->delete();
                //删除供应商信息
                Source_Product_ProductEntitySupplier::where( 'entity_id', $id )->delete();
                //删除库存信息
                Source_Product_ProductEntityStock::where( 'entity_id', $id )->delete();
                //删除配置产品信息
                Source_Product_ProductAttbuteJson::where( 'entity_id', $id )->delete();
                //删除购物车的产品
                Source_Cart_CartItem::where('product_id',$id)->delete();
                //删除收藏表
                Source_User_UserInfoCollect::where('entity_id',$id)->delete();
                //删除图片
                (new Upload())->delDir( 'goods', $id );
                //删除缓存图片
                (new Upload())->delDir('goods/cache',$id);
            });
            if ( is_null($result) )
            {
                return true;
            }else
            {
                return false;
            }
        }else
        {
            return false;
        }
    }


    /**
     *   上传内容里的图片
     *   $data 内容
     *   $id 产品编号
     */
    static function addContentImg( $data, $id )
    {
        if( $data == false || $id == false )
        {
            return $data;
        }
        $content = $data;
        //匹配图片
        preg_match_all( '/<img.*?src="(.*?)".*?>/is', $data, $array );
        foreach( $array[1] as $v)
        {
            if( $v )
            {
                $name = substr( $v, strrpos( $v, '/' )+1);
                (new Upload())->uploadProductImage( $id, $name, 'goods' );
                $url = "【img】".$id.'/'.$name;
                $content = str_replace( $v, $url, $content );
            }
        }
        return $content;
    }

    /**
     * @param $iPid
     * @param $dir
     * @param $name
     * 上传缩略图片
     */
    static function saveGoodsImg( $iPid, $dir, $name )
    {
        $Upload = new Upload();

        /*//复制文件
        $basePath =  public_path().'/media/temp/';
        copy($basePath.$name, $basePath.'68x68-'.$name);
        copy($basePath.$name, $basePath.'210x210-'.$name);
        copy($basePath.$name, $basePath.'430x430-'.$name);*/
        //上传原始图片
        $Upload->uploadProductImage( $iPid,$name, $dir);
        /* //裁剪
        getProductWater( $basePath.'68x68-'.$name, 68, 68);
        getProductWater( $basePath.'210x210-'.$name, 210, 210);
        getProductWater( $basePath.'430x430-'.$name, 430, 430);
        //上传
        $Upload->uploadProductImage( $iPid, '68x68-'.$name, $dir);
        $Upload->uploadProductImage( $iPid, '210x210-'.$name, $dir);
        $Upload->uploadProductImage( $iPid, '430x430-'.$name, $dir);*/
    }


    /**
     * @param $iPid
     * @param $dir
     * @param $name
     * 删除缩略图片
     */
    static function delGoodsImg( $iPid, $dir, $name )
    {
        $Upload = new Upload();
        //删除原图
        $Upload->delImg( $dir, $iPid, $name );
        //删除缓存图片
        $Upload->delDir($dir.'/cache',$iPid);
    }
}