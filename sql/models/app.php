<?php 

/**
* @author Oliver Valiente Oliva
*/

class App extends CI_Model
{
	
	function __construct()
	{
		# code...
	}

	public function timeline(){
		$this->load->database();
		$data = $this->db->get("activity");
		$data=$data->result('array');
		ob_clean();
		?>

		<div id="timeline" style="margin: 6%" class="row text-center container">
			
		  <h1>Esta es la Linea de Tiempo de las actividades</h1>
				<?php $b=false;  while($d = array_shift($data)): ?>
			<div class="row">
					<?php if($b){ $b=false;  ?>
					<div class="col-sm-4" style="height: 89px;float: left;margin-left: 15%;border-right: 2px solid #000;border-top: 2px solid #000">

	<span style="padding:10px;border-radius: 50%;"><?php echo $d['day']; ?></span> del mes <b><?php 
	 echo $d['month']; ?></b>

					</div>

				<?php 	}else{  ?>
					<div class="col-sm-4" style="height: 89px;float: right;margin-right: 18.56%;border-left: 2px solid #000;border-top: 2px solid #000">
						a
					</div>
					<?php $b = true;	} ?>
			</div>
				<?php  endwhile; ?>
		</div>

		<?php

		
		return ob_get_clean();
	}
}