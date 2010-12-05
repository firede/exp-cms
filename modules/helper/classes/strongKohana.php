<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of strongKohana
 *
 * @author Administrator
 */
class StrongKohana  extends Kohana_Core{
    /****
     * sss
     */
   public static function my_dump( & $var, $length = 128, $level = 0)
	{
		if ($var === NULL)
		{
			return 'NULL';
		}
		elseif (is_bool($var))
		{
			return ($var ? 'TRUE' : 'FALSE');
		}
		elseif (is_float($var))
		{
			return $var;
		}
		elseif (is_resource($var))
		{
			if (($type = get_resource_type($var)) === 'stream' AND $meta = stream_get_meta_data($var))
			{
				$meta = stream_get_meta_data($var);

				if (isset($meta['uri']))
				{
					$file = $meta['uri'];

					if (function_exists('stream_is_local'))
					{
						// Only exists on PHP >= 5.2.4
						if (stream_is_local($file))
						{
							$file = Kohana::debug_path($file);
						}
					}

					return htmlspecialchars($file, ENT_NOQUOTES, Kohana::$charset);
				}
			}
			else
			{
				return '';
			}
		}
		elseif (is_string($var))
		{
			// Clean invalid multibyte characters. iconv is only invoked
			// if there are non ASCII characters in the string, so this
			// isn't too much of a hit.
			$var = UTF8::clean($var);

			if (UTF8::strlen($var) > $length)
			{
				// Encode the truncated string
				$str = htmlspecialchars(UTF8::substr($var, 0, $length), ENT_NOQUOTES, StrongKohana::$charset).'&nbsp;&hellip;';
			}
			else
			{
				// Encode the string
				$str = htmlspecialchars($var, ENT_NOQUOTES, Kohana::$charset);
			}
                        if(is_string($str)){
                            return '"'.$str.'"';
                        }
			return ''.$str.'';
		}
		elseif (is_array($var))
		{
			$output = array();

			// Indentation for this variable
			$space = str_repeat($s = '    ', $level);

			static $marker;

			if ($marker === NULL)
			{
				// Make a unique marker
				$marker = uniqid("\x00");
			}

			if (empty($var))
			{
				// Do nothing
			}
			elseif (isset($var[$marker]))
			{
				$output[] = "(\n$space$s*RECURSION*\n$space)";
			}
			elseif ($level < 5)
			{
				$output[] = "(";

				$var[$marker] = TRUE;
				foreach ($var as $key => & $val)
				{
					if ($key === $marker) continue;
					if ( ! is_int($key))
					{
						$key = '"'.htmlspecialchars($key, ENT_NOQUOTES, self::$charset).'"';
					}

					$output[] = "$space$s$key => ".StrongKohana::my_dump($val, $length, $level + 1).",";
				}
				unset($var[$marker]);

				$output[] = "$space)";
			}
			else
			{
				// Depth too great
				$output[] = "(\n$space$s...\n$space)";
			}

			return 'array'.implode("\n", $output);
		}
		elseif (is_object($var))
		{
			// Copy the object as an array
			$array = (array) $var;

			$output = array();

			// Indentation for this variable
			$space = str_repeat($s = '    ', $level);

			$hash = spl_object_hash($var);

			// Objects that are being dumped
			static $objects = array();

			if (empty($var))
			{
				// Do nothing
			}
			elseif (isset($objects[$hash]))
			{
				$output[] = "(\n$space$s*RECURSION*\n$space)";
			}
			elseif ($level < 10)
			{
				$output[] = "(";

				$objects[$hash] = TRUE;
				foreach ($array as $key => & $val)
				{
					if ($key[0] === "\x00")
					{
						// Determine if the access is protected or protected
						$access = '';

						// Remove the access level from the variable name
						$key = substr($key, strrpos($key, "\x00") + 1);
					}
					else
					{
						$access = '';
					}
                                        $key='"'.$key.'"';
					$output[] = "$space$s$access $key =>".StrongKohana::my_dump($val, $length, $level + 1).",";
                                      
				}
				unset($objects[$hash]);

				$output[] = "$space)";
			}
			else
			{
				// Depth too great
				$output[] = "{\n$space$s...\n$space}";
			}

			return implode("\n", $output);
		}
		else
		{
			return gettype($var).htmlspecialchars(print_r($var, TRUE), ENT_NOQUOTES, Kohana::$charset);
		}
	}
}
?>
