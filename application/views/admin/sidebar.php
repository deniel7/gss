
<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
			<!--<li>
                            
			    <?php //echo anchor(site_url('admin/'),'<i class="fa fa-dashboard fa-fw"></i>Dashboard'); ?>
                        </li>
                        <li>
				<?php //echo anchor(site_url('admin/pesanan'),'<i class="fa fa-table fa-fw"></i>Orders'); ?>
			</li>
			<li>
				<?php //echo anchor(site_url('admin/delivery_order'),'<i class="fa fa-print fa-fw"></i>Print Orders'); ?>
			</li>-->
			<?php if($multiuser == 1){ ?>
			<li>
			
			<div class="col-xs-12">
				
				<div class="panel panel-active" style="margin-top: 30px">
					<a href="<?php echo base_url(); ?>admin/produk">
					<div class="panel-heading">
					    <div class="row">
						
						<button type="button" class="btn btn-default" style="width: 100%;">
						<div class="col-xs-9 text-left">
							<div style="font-size: 17px">Master Product</div>
							
							
						</div>
						<div class="col-xs-3 text-right">
						    <div>
							<i class="fa fa-edit fa-fw"></i>
						    </div>
						</div>
						</button>
						
					    </div>
					</div>
					</a>
				</div>
				
			</div>
			
			</li>
			<?php } ?>
			
			<?php if($multiuser == 0){ ?>
			
			<li>
			
			<div class="col-xs-12">
				
				<div class="panel panel-active" style="margin-top: 30px">
					<a href="<?php echo base_url(); ?>admin/">
					<div class="panel-heading">
					    <div class="row">
						
						<button type="button" class="btn btn-default" style="width: 100%;">
						<div class="col-xs-9 text-left">
							<div style="font-size: 17px">Dashboard</div>
							
							
						</div>
						<div class="col-xs-3 text-right">
						    <div>
							<i class="fa fa-dashboard fa-2x"></i>
						    </div>
						</div>
						</button>
						
					    </div>
					</div>
					</a>
				</div>
				
			</div>
			
			</li>
			
			
			<li>
			
			<div class="col-xs-12">
				
				<div class="panel panel-red">
					<a href="<?php echo base_url(); ?>admin/pesanan">
					<div class="panel-heading">
					    <div class="row">
						
						<button type="button" class="btn btn-danger" style="width: 100%">
						<div class="col-xs-9 text-left">
							<h4 id="c_pesanan"></h4>
							<div>New Orders!</div>
						</div>
						<div class="col-xs-3 text-right">
						    <div>
							<i class="fa fa-shopping-cart fa-2x"></i>
						    </div>
						</div>
						</button>
						
					    </div>
					</div>
					</a>
				</div>
				
			</div>
			
			</li>
			
			<li>
			
			<div class="col-xs-12">
				<div class="panel panel-yellow">
				    <div class="panel-heading">
					<div class="row">
					    
					    <button type="button" class="btn btn-warning" style="width: 100%">
					    <div class="col-xs-9 text-left">
						
						<h4 id="c_gold_proses"></h4>
						<div>Gold Process</div>
					    </div>
					    <div class="col-xs-3 text-right">
						<div>
							<i class="fa fa-tasks fa-2x"></i>
						</div>
					    </div>
					    </button>
					    
					</div>
				    </div>
				    
				</div>
			</div>
			
			</li>
			
			<li>
			
			<div class="col-xs-12">
				<div class="panel panel-info">
					<a href="<?php echo base_url(); ?>admin/delivery_order">
					<div class="panel-heading">
					    <div class="row">
						
						
						<button type="button" class="btn btn-info" style="width: 100%">
						<div class="col-xs-9 text-left"">
						    <h4 id="c_print_do"></h4>
						    <div>Print Delivery Order</div>
						</div>
						<div class="col-xs-3 text-right">
						    <div>
						    <i class="fa fa-print fa-2x"></i>
						    </div>
						</div>
						</button>
						
						
					    </div>
					</div>
					</a>
				</div>
			</div>
			
			</li>
			
			<li>
			
			<div class="col-xs-12">
				<div class="panel panel-info">
					<a href="<?php echo base_url(); ?>admin/receiving">
					<div class="panel-heading">
					    <div class="row">
						
						
						<button type="button" class="btn btn-success" style="width: 100%">
						<div class="col-xs-9 text-left"">
						    <h4 id="c_receiving"></h4>
						    <div>Receiving DN</div>
						</div>
						<div class="col-xs-3 text-right">
						    <div>
						    <i class="fa fa-print fa-2x"></i>
						    </div>
						</div>
						</button>
						
						
					    </div>
					</div>
					</a>
				</div>
			</div>
			
			</li>
			<?php } ?>
			<!--<li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.html">Flot Charts</a>
                                </li>
                                <li>
                                    <a href="morris.html">Morris.js Charts</a>
                                </li>
                            </ul>
                            
                        </li>
                        <li>
                            <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="panels-wells.html">Panels and Wells</a>
                                </li>
                                <li>
                                    <a href="buttons.html">Buttons</a>
                                </li>
                                <li>
                                    <a href="notifications.html">Notifications</a>
                                </li>
                                <li>
                                    <a href="typography.html">Typography</a>
                                </li>
                                <li>
                                    <a href="grid.html">Grid</a>
                                </li>
                            </ul>
                            
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    
                                </li>
                            </ul>
                            
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                            
                        </li>-->
                    </ul>
                </div>
                
            </div>
            
        </nav>