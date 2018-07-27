<?php  
	
	/**
	 * 
	 */
	interface War
	{
		public function isPartida_em_andamento();
		public function sortearPaises();
		public function isFronteira($origem,$destino);
		public function ataqueUsuario($origem,$destino);
		public function ataqueCPU($origem,$destino);
		public function maiorVantagem();
		public function sortearExercitos();
		public function isVencedor();
		public function zerarPartida();
		public function carregarDados();
	}
?>