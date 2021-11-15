<form method="post" action="./PaytmKit/pgRedirect.php">
            <div class="row">

                <!-- <div class="col-12">
                    <div class="d-flex flex-column px-md-5 px-4 mb-4"> <span class="mb-3">Phonepe | Paytm | Gpay</span>
                        <div class="inputWithIcon"> <input class="form-control fs-4" value="9548523294"  type="text" disabled> </div>
                    </div>
                </div> -->

                <div class="col-12">
                    <div class="d-flex flex-column px-md-5 px-4 mb-4"> 
                      <!-- <span class="mb-3">ORDER_ID</span> -->
                        <div class="inputWithIcon"> <input class="form-control fs-4" id="ORDER_ID" class="form-control" tabindex="1" maxlength="20" size="20"
                  name="ORDER_ID" autocomplete="off"
                  value="<?php echo  "ORDS" . rand(10000,99999999)?>" hidden>
                        </div>
                    </div>
                </div>
                  <?php
                          if(isset($_SESSION['id']))
                          {
                            $disable = 'disabled';
                          }else{
                            $disable = "";
                          }
                  ?>
                <div class="col-12">
                    <div class="d-flex flex-column px-md-5 px-4 mb-4"> 
                      <span class="h5 m-0" style="font-size:15px;">Name</span>
                        <div class="inputWithIcon"> <input type="text" class="form-control" name="username" autocomplete="off" value="<?php echo isset($_SESSION['id'])?$_SESSION['name']:'';?>" require <?php echo $disable; ?>>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="d-flex flex-column px-md-5 px-4 mb-4"> 
                      <span class="h5 m-0" style="font-size:15px;">EMAIL OR PHONE</span>
                        <div class="inputWithIcon"> <input id="CUST_ID" type="text" class="form-control"  tabindex="2"  name="CUST_ID" autocomplete="off" value="<?php echo isset($_SESSION['id'])?$_SESSION['mailid']:'';?>" require <?php echo $disable; ?>>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="d-flex flex-column px-md-5 px-4 "> 
                      <!-- <span class="mb-3">INDUSTRY_TYPE_ID</span> -->
                        <div class="inputWithIcon"> <input id="INDUSTRY_TYPE_ID" class="form-control"  tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail" hidden>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-column px-md-5 px-4 "> 
                      <!-- <span class="mb-3">CHANNEL_ID</span> -->
                        <div class="inputWithIcon"> <input id="CHANNEL_ID" class="form-control" tabindex="4" maxlength="12"
						size="12" name="CHANNEL_ID" autocomplete="off" value="WEB" hidden>
                        </div>
                    </div>
                </div>
                <input name="ss" value="<?php echo isset($_SESSION['id'])?'yes':'no';?>" hidden>
                <div class="col-12">
                    <div class="d-flex flex-column px-md-5 px-4 mb-4"> 
                      <span class="mb-2 h5 fw-bold m-0" style="color:#a37474;">DONATION</span>
                        <div class="inputWithIcon"> <input title="TXN_AMOUNT" class="form-control text-center" tabindex="10"
						 name="TXN_AMOUNT"
						value="100" >
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="d-flex flex-column px-md-5 px-4 mb-4 text-end">
                        <div class="number" >
                            <span class="minus">-</span>
                            <input type="text" value="50" disabled/>
                            <span class="plus">+</span>
                        </div>
                    </div>
                </div>

                <!-- <div class="px-md-5 px-4 ">
                    <div class="row">
                        <div class="number">
                            <span class="minus">-</span>
                            <input type="text" value="50"/>
                            <span class="plus">+</span>
                        </div>
                    </div>
                </div> -->

              

                <!-- <div class="col-12">
                    <div class="d-flex flex-column px-md-5 px-4 mb-4"> <span>Or click on this <a href="https://instamojo.com/@gauravsolo" target="_blank" style="" >link</a></span>
                        <div class="inputWithIcon">  <span class="far fa-user"></span> </div>
                    </div>
                </div> -->

                <div class="col-12 px-md-5 px-4 mt-3">
                    <input class="btn btn-primary w-100 " type="submit" value="CheckOut">
                </div>
            </div>
        </form>