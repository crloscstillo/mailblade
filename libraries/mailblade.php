<?php use \SMTP;

class Mailblade extends SMTP {

	/**
	 * The template name.
	 *
	 * @var string
	 */
	public $template_name;

	/**
	 * The template parameters.
	 *
	 * @var string
	 */
	public $template_params;

	#							~ ---------- ~							#

	/**
	 * Set template name and parameters.
	 * 
	 * @param   string    $name
	 * @param   array     $data
	 * @return  Mailblade
	 */
	public function template($name, $data=null)
	{
		$this->template_name = $name;

		if (is_array($data))
		{
			$this->template_params = $data;
		}

		return $this;
	}

	/**
	 * Set a parameter for the template.
	 * 
	 * @param  string $param 
	 * @param  string $value     
	 * @return Mailblade
	 */
	public function with($param, $value)
	{
		$this->template_params[$param] = $value;
		return $this;
	}

	#							~ ---------- ~							#

	/**
	 * Compile the email template.
	 * 
	 * @return Mailblade
	 */
	public function compile()
	{
		$html = $this->compile_html();
		$text = $this->compile_text();

		$this->body($html);
		$this->text($text);

		return $this;
	}

	/**
	 * Compile html email.
	 * 
	 * @return string
	 */
	public function compile_html()
	{
		$content = $this->get_template('html');

		foreach ($this->template_params as $param => $value)
		{
			$content = preg_replace("/\{\{$param\}\}/", $value , $content);
		}

		return $content;
	}

	/**
	 * Compile text email.
	 * 
	 * @return string
	 */
	public function compile_text()
	{
		$content = $this->get_template('text');

		foreach ($this->template_params as $param => $value)
		{
			$content = preg_replace("/\{\{$param\}\}/", $value , $content);
		}
		
		return $content;
	}

	/**
	 * Get template file.
	 * Allowed values: html|text
	 * 
	 * @param  string $type
	 * @return string
	 */
	public function get_template($type)
	{
		return file_get_contents(Bundle::path('mailblade').'templates'.DS.$type.DS.$this->template_name.'.php');
	}
}