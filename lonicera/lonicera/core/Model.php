<?php
/**
 * 数据模型类
 * 使用pdo构建
 */
class Db{
    private $dbLink;    //链接
    protected $queryNum = 0;
    private static $instance;
    protected $PDOStatement;
    //事务数
    protected $transTimes = 0;
    protected $bind = [];
    public $rows = 0;
    private function __construct($config){
        $this->connect($config);
    }
    public static function getInstance($config){    //单例，
        if(!self::$instance instanceof self){
            self::$instance = new self($config);
        }
        return self::$instance;
    }
    //连接
    public function connect($config){
        try{
            $dsn = $config['database'].':host='.$config['ip'].';dbname='.$config['dbName'];
            $this->dbLink = new PDO($dsn,$config['username'],$config['password']);
        }catch(\PDOException $e){
            throw $e;
        }
        return $this->dbLink;
    }
    //
    public function query($sql,$bind = [],$fetchType = PDO::FETCH_ASSOC){
        if(!$this->dbLink){
            throw new Exception('数据库连接失败');
        }
        $this->PDOStatement = $this->dbLink->prepare($sql);
        $this->PDOStatement->execute($bind);
        $ret = $this->PDOStatement->fetchAll($fetchType);
        $this->rows = count($ret);
        return $ret;
    }
    public function execute($sql,$bind = []){
        if(!$this->dbLink){
            throw new Exception('数据库连接失败');
        }
        $this->PDOStatement = $this->dbLink->prepare($sql);
        $ret = $this->PDOStatement->execute($bind);
        $this->rows = $this->PDOStatement->rowCount();
        return $ret;
    }
    //事务
    public function startTrans(){
        ++$this->transTimes;
        if($this->transTimes == 1){     //不存在已创建事务才开启新事务
            $this->dbLink->beginTransaction();
        }else{
            $this->dbLink->execute("SAVEPOINT tr{$this->transTimes}");
        }
    }
    public function commit(){
        if($this->transTimes == 1){
            $this->dbLink->commit();
        }
        --$this->transTimes;
    }
    public function rollback(){
        if($this->transTimes == 1){
            $this->dbLink->rollBack();
        }elseif ($this->transTimes > 1){
            $this->dbLink->execute("ROLLBACK TO SAVEPOINT tr{$this->transTimes}");
        }
        $this->transTimes = max(0,$this->transTimes - 1);
    }

}