
    <div class="container-fluid">
        <br>
        <hr>
        <!--设备类型-->
        <h1>
            <?php echo Defines::$gDevModel[$model] ?>
        </h1>
        <!--添加普通信号-->
        <div class="row-fluid">
            <div class="span12">
                <div class="content-widgets light-gray">
                    <div class="widget-head bondi-blue">
                        <h3>添加信号名称映射</h3>
                    </div>
                    <div class="widget-container">
                        <table
                                class="table table-bordered responsive table-striped table-sortable">
                            <thead>
                            <tr>
                                <th width="10%">信号变量名称</th>
                                <th width="10%">变量中文名</th>
                                <th width="10%">信号变量单位</th>
                                <th width="10%">变量类型</th>
                                <th width="10%">描述</th>
                                <th width="5%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <!--                                信号变量名称-->
                                <td>
                                    <input type="hidden" class="loop_model" value="<?php echo $model ?>" ?>
                                    <input type="hidden" class='loop_id'  value="<?php echo $id ?>" ?>
                                    <input type="text" class="input desc parameter span10" name="parameter">
                                </td>
                                <!--                                变量中文名-->
                                <td>
                                    <input type="text" class="input desc signal_name span10" name="signal_name">
                                </td>
                                <!--                                信号变量单位-->
                                <td>
                                    <select class="chzn-select signal_unit span12" data-placeholder="选择变量单位"
                                            name='signal_unit' id='signal_unit'>
                                        <option value=''>
                                            选择变量单位
                                        </option>
                                        <option value='1'>无单位
                                        </option>
                                        <option value='2'>℃
                                        </option>
                                    </select>
                                </td>
                                <!--                                变量类型-->
                                <td>
                                    <select class="chzn-select signal_type span 12" data-placeholder="选择标准信号名"
                                            name='signal_type' id='signal_type'>
                                        <option value=''>
                                            选择标准信号变量类型
                                        </option>
                                        <option value='a'>NUL-padded string</option>
                                        <option value='A'>SPACE-padded string</option>
                                        <option value='h'>Hex string, low nibble first</option>
                                        <option value='H'>Hex string, high nibble first</option>
                                        <option value='c'>signed char</option>
                                        <option value='C'>unsigned char</option>
                                        <option value='s'>signed short (always 16 bit, machine byte order)</option>
                                        <option value='S'>unsigned short (always 16 bit, machine byte order)</option>
                                        <option value='n'>unsigned short (always 16 bit, big endian byte order)</option>
                                        <option value='v'>unsigned short (always 16 bit, little endian byte order)
                                        </option>
                                        <option value='i'>signed integer (machine dependent size and byte order)
                                        </option>
                                        <option value='I'>unsigned integer (machine dependent size and byte order)
                                        </option>
                                        <option value='l'>signed long (always 32 bit, machine byte order)</option>
                                        <option value='L'>unsigned long (always 32 bit, machine byte order)</option>
                                        <option value='N'>unsigned long (always 32 bit, big endian byte order)</option>
                                        <option value='V'>unsigned long (always 32 bit, little endian byte order)
                                        </option>
                                        <option value='f'>float (machine dependent size and representation)</option>
                                        <option value='d'>double (machine dependent size and representation)</option>
                                        <option value='x'>NUL byte</option>
                                        <option value='X'>Back up one byte</option>
                                        <option value='@'>NUL-fill to absolute position</option>
                                    </select>
                                </td>

                                <!--                                描述-->
                                <td>
                                    <textarea class="span12 signal_desc" name='signal_desc span10' id='signal_desc'></textarea>
                                </td>

                                <input type="hidden" class="input desc type" value=1>
                                <td>
                                    <input type="submit"
                                           class="btn btn-success add_realtime_signal" value="添加信号"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--管理-->
    <div class="row-fluid">
        <div class="span12">
            <div class="content-widgets light-gray">
                <div class="widget-head bondi-blue">
                    <h3>管理信号名称</h3>
                </div>
                <div class="widget-container">
                    <table
                            class="table table-bordered responsive table-striped table-sortable">
                        <thead>
                        <tr>
                            <th width="13%">信号变量名称</th>
                            <th width="18%">变量中文名</th>
                            <th width="10%">信号变量单位</th>
                            <th width="10%">变量类型</th>
                            <th width="">描述</th>
                            <th width="10%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($signals as $s) { ?>
                            <tr>
                                <td>
                                    <input type="hidden" class='loop_id'  value="<?php echo $id ?>" ?>
                                    <span>

                                    </span>

                                    <input type="text" class="input parameter span12"  readonly="readonly"
                                           value="<?php echo $s->parameter ?>">
                                </td>
                                <!-- 变量中文名-->
                                <td>
                                    <input type="text" class="input signal_name_update span15"
                                           value="<?php echo $s->name ?>">
                                </td>
                                <td>
                                    <select class="chzn-select signal_unit_update span12" data-placeholder="选择变量单位"
                                            name='signal_unit_update' >
                                        <option value='1' <?php if ($s->unit == 1) {
                                            echo "selected=" . "selected";
                                        } ?>>无单位
                                        </option>
                                        <option value='2' <?php if ($s->unit == 2) {
                                            echo "selected=" . "selected";
                                        } ?>>℃
                                        </option>
                                    </select>
                                </td>
                                <!--                                   标准信号变量类型 -->
                                <td>
                                    <select class="chzn-select signal_type_update" data-placeholder="选择标准信号变量类型"
                                            name='signal_type_update'>
                                        <option value='<?php echo $s->type; ?>'>
                                            <?php echo $this->mp_extra->getRealtimeSignalType($s->type); ?>
                                        </option>
                                        <option value='a'>NUL-padded string</option>
                                        <option value='A'>SPACE-padded string</option>
                                        <option value='h'>Hex string, low nibble first</option>
                                        <option value='H'>Hex string, high nibble first</option>
                                        <option value='c'>signed char</option>
                                        <option value='C'>unsigned char</option>
                                        <option value='s'>signed short (always 16 bit, machine byte order)</option>
                                        <option value='S'>unsigned short (always 16 bit, machine byte order)
                                        </option>
                                        <option value='n'>unsigned short (always 16 bit, big endian byte order)
                                        </option>
                                        <option value='v'>unsigned short (always 16 bit, little endian byte order)
                                        </option>
                                        <option value='i'>signed integer (machine dependent size and byte order)
                                        </option>
                                        <option value='I'>unsigned integer (machine dependent size and byte order)
                                        </option>
                                        <option value='l'>signed long (always 32 bit, machine byte order)</option>
                                        <option value='L'>unsigned long (always 32 bit, machine byte order)</option>
                                        <option value='N'>unsigned long (always 32 bit, big endian byte order)
                                        </option>
                                        <option value='V'>unsigned long (always 32 bit, little endian byte order)
                                        </option>
                                        <option value='f'>float (machine dependent size and representation)</option>
                                        <option value='d'>double (machine dependent size and representation)
                                        </option>
                                        <option value='x'>NUL byte</option>
                                        <option value='X'>Back up one byte</option>
                                        <option value='@'>NUL-fill to absolute position</option>
                                    </select>
                                </td>

                                <!--                                    描述-->
                                <td>
                                    <textarea class="span12 signal_desc_update" name='signal_desc_update'
                                              id='signal_desc'><?php echo $s->desc ?></textarea>
                                </td>

                                <td>
                                    <input type="submit" class="update_realtime_signal" value="更改">
                                    <input type="submit" class="delete_realtime_signal" value="删除">
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




