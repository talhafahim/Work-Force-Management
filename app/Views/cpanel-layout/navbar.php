<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
	<div class="slimscroll-menu" id="remove-scroll">
		<!--- Sidemenu -->
		<div id="sidebar-menu">
			<!-- Left Menu Start -->
			<ul class="metismenu" id="side-menu">
				<li class="menu-title"><center><?= session()->get('fname')?> | <?= session()->get('status')?> </center></li>
				
				<!-- <li><a href="<?= base_url();?>/dashboard" class="waves-effect"><i class="fa fa-home"></i><span>Dashboard</span></a></li> -->
				<?php if(session()->get('status') == 'hide'){ // change status from show to admin?> 
					<li><a href="<?= base_url();?>/dashboard-menu-management" class="waves-effect"><i class="fa fa-bars"></i><span>Menu Management</span></a></li>
				<?php } ?>

				<?php 
				$menu_query = menu();
				foreach($menu_query->get()->getResult() as $menuValue){
					if($menuValue->has_submenu == 0){
						$submenu_query = submenu($menuValue->id)->get()->getRow();
						if(parent_view($menuValue->id)){
							?>
							<li><a href="<?= base_url().$submenu_query->route;?>" class="waves-effect"><i class="<?= $menuValue->icon;?>"></i><span><?= $menuValue->menu;?></span></a></li>
						<?php } }else{
							$submenu_query = submenu($menuValue->id);
							if(parent_view($menuValue->id)){
								?>
								<li>
									<a href="javascript:void(0);" class="waves-effect"><i class="<?= $menuValue->icon;?>"></i><span> <?= $menuValue->menu;?> <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></span></a>
									<ul class="submenu">
										<?php foreach($submenu_query->get()->getResult() as $submenuValue){
											if(access_crud($submenuValue->submenu,'view')){ ?>
												<li>
													<?php if($submenuValue->type == 'route'){?>
														<a href="<?= base_url().$submenuValue->route;?>"><?= $submenuValue->submenu;?></a>
													<?php }else{ ?>
														<a href="#"  data-toggle="modal" data-target="<?= $submenuValue->route;?>"><?= $submenuValue->submenu;?></a>
													<?php } ?>
													</li>
												<?php } } ?>
											</ul>
										</li>
									<?php } } } ?>
								</ul>
							</div>
							<!-- Sidebar -->
							<div class="clearfix"></div>
						</div>
						<!-- Sidebar -left -->
					</div>
<!-- Left Sidebar End -->