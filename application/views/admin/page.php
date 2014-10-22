<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $total_pesanan; ?></div>
                                    <div>New Orders!</div>
                                </div>
                            </div>
                        </div>
                        <a href="admin/pesanan">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $gold_proc; ?></div>
                                    <div>Processing on Gold</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"><br/></span>
                                <span class="pull-right"></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-print fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $print_order; ?></div>
                                    <div>Print Delivery Order</div>
                                </div>
                            </div>
                        </div>
                        <a href="admin/delivery_order">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-shopping-cart fa-fw"></i> Latest Orders
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                            <tr>
                                              <td>Nomor Transaksi</td>
                                              <td>Cabang</td>
                                              <td>Waktu</td>
                                              <td>Total</td>
                                              <td>SPV</td>
                                              <td>No. Struk</td>
                                              <td>Status</td>
                                            </thead>
                                            <tbody>
                                            <?php if($pesanan!= array()): ?>
                                                    <?php foreach ($pesanan as $item): ?>
                                                            <tr>
                                                                <td><?php echo $item->ORDER_NO_GTRON; ?></td>
                                                                <td><?php echo $item->SITE_STORE_CODE; ?></td>
                                                                <td><?php echo $item->tanggal_masuk; ?></td>
                                                                <td><?php echo $this->cart->format_number($item->total_biaya); ?></td>
                                                                <td><?php echo $item->USERNAME; ?></td>
                                                                <td><?php echo $item->no_struk; ?></td>
                                                                <td>
                                                                    
                                                                    <?php
                                                                    
                                                                            switch($item->FLAG) {
                                                                            
                                                                            case '0':
                                                                            $item->FLAG = '<div style="color:red;">Booked</div>';
                                                                            continue;
                                                                            
                                                                            case '1':
                                                                            $item->FLAG = '<div style="color:orange;">Confirmed</div>';
                                                                            continue;
                                                                            
                                                                            case '2':
                                                                            $item->FLAG = '<div style="color:blue;">Picking List Submited</div>';
                                                                            continue;
                                                                            
                                                                            case '3':
                                                                            $item->FLAG = '<div style="color:purple;">on Progress</div>';
                                                                            continue;
                                                                            
                                                                            case '4':
                                                                            $item->FLAG = '<div style="color:silver;">Cancel</div>';
                                                                            continue;
                                                                    
                                                                            case '5':
                                                                            $item->FLAG = '<div style="color:chocolate;">Shipment Gold</div>';
                                                                            continue;
                                                                    
                                                                            case '6':
                                                                            $item->FLAG = '<div style="color:green;">on Delivery</div>';
                                                                            continue;
                                                                    
                                                                            case '7':
                                                                            $item->FLAG = '<div style="color:pink;">Receiving Gold</div>';
                                                                            continue;
                                                                    
                                                                            case '8':
                                                                            $item->FLAG = '<div style="color:black;">Gold Error!</div>';
                                                                            continue;
                                                                
                                                                            }          
                                                                    echo $item->FLAG;
                                                                    ?>
                                                                
                                                                </td>
                                                                
                                                            </tr>
                                                    <?php endforeach; ?>
                                                    
                                            <?php else: ?>
                                                <p class="bg-info">Belum ada Pesanan</p>
                                            <?php endif; ?>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                                
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Recent Activities
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-shopping-cart fa-fw"></i> New Order Placed
                                    <span class="pull-right text-muted small"><em>9:59 AM</em>
                                    </span>
                                </a>
                                
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-shopping-cart fa-fw"></i> New Order Placed
                                    <span class="pull-right text-muted small"><em>9:49 AM</em>
                                    </span>
                                </a>
                                
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-truck fa-fw"></i> Delivering Order
                                    <span class="pull-right text-muted small"><em>43 minutes ago</em>
                                    </span>
                                </a>
                                
                                <!--<a href="#" class="list-group-item">
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small"><em>4 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small"><em>12 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small"><em>27 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small"><em>43 minutes ago</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small"><em>11:32 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-bolt fa-fw"></i> Server Crashed!
                                    <span class="pull-right text-muted small"><em>11:13 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-warning fa-fw"></i> Server Not Responding
                                    <span class="pull-right text-muted small"><em>10:57 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-shopping-cart fa-fw"></i> New Order Placed
                                    <span class="pull-right text-muted small"><em>9:49 AM</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-money fa-fw"></i> Payment Received
                                    <span class="pull-right text-muted small"><em>Yesterday</em>
                                    </span>
                                </a>-->
                            </div>
                            <!-- /.list-group -->
                            <a href="#" class="btn btn-default btn-block">View All Alerts</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
                    