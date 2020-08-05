<?php 
	/**
	 * Представление
	 */
	class View
	{
		
		public function render($template, $view, $data = null) {
			if ($data != null) {
				extract($data);
			}
			include $template;
		}
	}
?>