<?php
/**
 *
 * @package phpBB Extension - Activity Stats
 * @copyright (c) 2014 Robet Heim
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */
namespace robertheim\activitystats\tests\mock;

class cache_mock implements \phpbb\cache\driver\driver_interface
{
	protected $data;

	public function __construct($data = array())
	{
		$this->data = $data;
	}

	public function get($var_name)
	{
		if (isset($this->data[$var_name]))
		{
			return $this->data[$var_name];
		}

		return false;
	}

	public function put($var_name, $var, $ttl = 0)
	{
		$this->data[$var_name] = $var;
	}

	function load()
	{
	}
	function unload()
	{
	}
	function save()
	{
	}
	function tidy()
	{
	}
	function purge()
	{
	}
	function destroy($var_name, $table = '')
	{
		unset($this->data[$var_name]);
	}
	public function _exists($var_name)
	{
	}
	public function sql_load($query)
	{
	}
	public function sql_save(\phpbb\db\driver\driver_interface $db, $query, $query_result, $ttl)
	{
		return $query_result;
	}
	public function sql_exists($query_id)
	{
	}
	public function sql_fetchrow($query_id)
	{
	}
	public function sql_fetchfield($query_id, $field)
	{
	}
	public function sql_rowseek($rownum, $query_id)
	{
	}
	public function sql_freeresult($query_id)
	{
	}
}
