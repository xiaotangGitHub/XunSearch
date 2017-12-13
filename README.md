_A simple DEMO based on PHP-SDK integration based on XunSearch_
--------------------------------------------------------------------------------
<pre>
    /**
     * Search constructor.
     * @param string $file_ini The configuration file of Xun search
     * @param array $config
     */
    public function __construct( $file_ini, array $config = [] )
</pre>
<pre>
    /**
     * @function Get the search results
     * @param $field
     * @return array
     */
    public function search( $field )
</pre>
<pre>
    /**
     * @function Index data added to XunSearch
     * @param array $data
     * @return array
     */
    public function addData( array $data )
</pre>
<pre>
    /**
     * @function Update the index data with the same primary key value
     * @param array $data
     * @return array
     */
    public function updateData( array $data )
</pre>
<pre>
    /**
     * @function Deleting index data based on the primary key value
     * @param $primaryKey
     */
    public function delData( $primaryKey )
</pre>
<pre>
    /**
     * @function Configuring the number of data to search
     * @param int $length
     * @param int $offset
     * @return $this
     */
    public function limit( $length = 10, $offset = 0 )
</pre>
<pre>
    /**
     * @function Scavenging index data when data is seriously out of sync
     */
    public function clear()
</pre>
<pre>
    /**
     * @function After the index data is processed, the index data is refreshed immediately to make it effective
     * Index refresh configuration needs to be opened
     */
    private function refresh()
</pre>

##_基于xunsearch php-sdk集成简单的演示_
<pre>
    /**
     * Search constructor.
     * @param string $file_ini 迅搜的配置文件名
     * @param array $config
     */
    public function __construct( $file_ini, array $config = [] )
</pre>
<pre>
    /**
     * @function 获取搜索结果
     * @param $field
     * @return array
     */
    public function search( $field )
</pre>
<pre>
    /**
     * @function 将索引数据添加到迅搜
     * @param array $data
     * @return array
     */
    public function addData( array $data )
</pre>
<pre>
    /**
     * @function 用相同的主键值更新索引数据
     * @param array $data
     * @return array
     */
    public function updateData( array $data )
</pre>
<pre>
    /**
     * @function 基于主键值删除索引数据
     * @param $primaryKey
     */
    public function delData( $primaryKey )
</pre>
<pre>
    /**
     * @function 配置要搜索的数据的数目
     * @param int $length
     * @param int $offset
     * @return $this
     */
    public function limit( $length = 10, $offset = 0 )
</pre>
<pre>
    /**
     * @function 当数据严重不同步时清除索引数据
     */
    public function clear()
</pre>
<pre>
    /**
     * @function 在处理索引数据之后，立即刷新索引数据以使其生效。
     * 索引刷新配置需要打开
     */
    private function refresh()
</pre>

###使用该扩展需编译安装XunSearch，且开启XunSearch服务###
<pre>
#下载包
mkdir /usr/local/xunsearch
wget http://www.xunsearch.com/download/xunsearch-full-latest.tar.bz2
tar -xjf xunsearch-full-latest.tar.bz2
</pre>
<pre>
#安装
cd xunsearch-full-1.3.0/
sh setup.sh
</pre>
<pre>
#查看运行结果
/usr/local/xunsearch/sdk/php/util/RequiredCheck.php -c gbk
</pre>
<pre>
#启动服务并注册服务
/usr/local/xunsearch/bin/xs-ctl.sh restart
cp /usr/local/xunsearch/bin/xs-ctl.sh /etc/init.d/xs-indexed
chkconfig --add xs-indexed
</pre>
