<ul id="menu1">
	<?php $ii=1; foreach($list_empresam as $emp){ ?>
		<li><input type="checkbox" checked="" name="list" id="<?php echo 'nivel1-'.$ii ?>"><label for="<?php echo 'nivel1-'.$ii ?>"><b><?php echo "Empresa - ".$emp['nom_modulo_mae'] ?></b></label>
			<ul class="interior">
				<?php $yy=1; $cont=count($list_modulo); foreach($list_modulo as $modulo){
					if($modulo['id_menu_mae']==$emp['id_modulo_mae']){?>
						<li><input type="checkbox" name="list"  id="<?php echo 'nivel2-'.$yy ?>">
						<label for="<?php echo 'nivel2-'.$yy ?>"><input type="checkbox"  name="<?php echo 'id_modulo_grupo'.$emp['id_modulo_mae'].'-'.$modulo['id_modulo_grupo'].'[]' ?>" id="<?php echo 'id_modulo_grupo'.$emp['id_modulo_mae'].'-'.$modulo['id_modulo_grupo'].'[]' ?>" onclick="todo_modulo('<?php echo $emp['id_modulo_mae'] ?>','<?php echo $modulo['id_modulo_grupo'] ?>');" value="<?php echo $modulo['id_modulo_grupo'] ?>"
						<?php $i=0;$y=0; foreach($list_submodulo as $sub){
							if($sub['id_modulo_grupo']==$modulo['id_modulo_grupo'] && $sub['id_modulo_subgrupo_n']!=""){ $i=$i+1;}
							if($sub['id_modulo_grupo']==$modulo['id_modulo_grupo']){$y=$y+1;} } 
								if($i==$y && $y!=0){ echo "checked";} ?>

						>
						<?php echo "Modulo ".$modulo['nom_modulo_grupo']; ?></label> 
							<ul class="interior">
								<?php $z=1;$cont1=count($list_submodulo); foreach($list_submodulo as $sub){
									if($sub['id_modulo_mae']=$emp['id_modulo_mae'] && $sub['id_modulo_grupo']==$modulo['id_modulo_grupo']){?>
										<li><input type="checkbox" checked="" name="list"  id="<?php echo 'nivel3-'.$z ?>">
										<label for="<?php echo 'nivel3-'.$z ?>"><input type="checkbox" class="<?php echo 'sub'.$modulo['id_modulo_grupo'] ?>" name="<?php echo 'id_modulo_subgrupo'.$modulo['id_modulo_grupo'].'-'.$sub['id_modulo_subgrupo'].'[]' ?>" id="<?php echo 'id_modulo_subgrupo'.$modulo['id_modulo_grupo'].'-'.$sub['id_modulo_subgrupo'].'[]' ?>" onclick="todo_submodulo('<?php echo $modulo['id_modulo_grupo'] ?>','<?php echo $sub['id_modulo_subgrupo'] ?>');" value="<?php echo $sub['id_modulo_subgrupo'] ?>"
										
										<?php $i=0; $y=0; foreach($list_sub_submodulo as $subsub){
											if($subsub['id_modulo_subgrupo']==$sub['id_modulo_subgrupo'] && $subsub['id_modulo_sub_subgrupo_n']!=""){$i=$i+1;}
											if($subsub['id_modulo_subgrupo']==$sub['id_modulo_subgrupo']){$y=$y+1;} } 
											if($y!=0 && $i==$y){ echo "checked"; }else{ if($sub['id_modulo_subgrupo_n']!="" && $y==0){echo "checked"; }} ?>

										>&nbsp;<?php echo $sub['nom_subgrupo'] ?></label>
										
										<ul class="interior">
											<?php  foreach($list_sub_submodulo as $subsub){
												if($subsub['id_modulo_subgrupo']==$sub['id_modulo_subgrupo']){?>
													<a href="#r"><input type="checkbox" class="<?php echo 'sub'.$modulo['id_modulo_grupo'] ?>" name="<?php echo 'id_modulo_sub_subgrupo'.$sub['id_modulo_subgrupo'].'-'.$subsub['id_modulo_sub_subgrupo'].'[]'; ?>" id="<?php echo 'subsub'.$modulo['id_modulo_grupo'].'-'.$sub['id_modulo_subgrupo']; ?>" value="<?php echo $subsub['id_modulo_sub_subgrupo'] ?>" <?php if($subsub['id_modulo_sub_subgrupo_n']!=""){ echo "checked"; } ?>>&nbsp;<?php echo $subsub['nom_sub_subgrupo'] ?></a></li><br>
												<?php }  }?>
											
										</ul>
										
									<?php } $z=$z+1; $cont1=$cont1-1; if($cont1<1){ $z=0;} }?>
							</ul>
						</li>
					<?php } $y=$y+1; $cont=$cont-1; if($cont<1){ $y=0;} $yy=$yy+1;}?>
			</ul>
		</li>
	<?php  $ii=$ii+1; }  ?>
	
</ul>