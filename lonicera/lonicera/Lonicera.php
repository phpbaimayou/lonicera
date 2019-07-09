<?php
/**
 * 项目核心文件
 * 加载其他
 */
class Lonicera{
    private $route;
    //核心方法
    public function run(){
        $this->route();
        $this->dispatch();
    }
    //路由分发和调度
    public function route(){
        $this->route = new Route();
        $this->route->init();
    }
    public function dispatch(){
        $controll = $this->route->controll;
        $controlName = $this->route->controll.'Controller';
        $action = $this->route->action;
        $actionName = $this->route->action.'Action';
        $param = $this->route->param;
        $path = _APP.$this->route->group.DIRECTORY_SEPARATOR.'module';
        $path .= DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.$controlName.'.php';
        require_once $path;
        $methods = get_class_methods($controll);
        if(!in_array($action,$methods,TRUE)){
            throw new exception(sprintf('方法名 %s->%s 不存在',$controlName,$actionName));
        }
        $handler = new $controll();
        $handler->param = $param;
        $handler-> {$action}();//执行方法
    }
}