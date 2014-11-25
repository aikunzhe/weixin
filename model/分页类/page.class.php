<?php
//
class page
{
	public $pageSize;//每页显示行数       分页的大小
	public $pageNow;//当前的页面位置 表示当前的页面位置 
    public $uri; //表示 url 分页导航条的url 和 下一页
    public $page_whole =5;//分页导航条 显示 1,2,3,4,5，
    public $config =array(
    'header'=>'条记录',
    'first'=>'首页',
    'last'=>'尾页',
    'prev'=>'上一页',    
    'next'=>'下一页',
    'goto'=>'跳转',   
    );
    
	public $res_array;//分页数据结果集,导出到该数组
	public $rowCount;//从数据库获取记录总数目		
	public $pageCount;//由上两个,计算得出的   表示一共有多少页

	
	public function  __construct($pageSize,$pageNow,$uri,$page_whole)
	{
		$this->pageSize = $pageSize;
		$this->pageNow = $pageNow;	
        $this->uri = $uri;
        $this->page_whole = $page_whole;
	}

	public function is_right()//判断数据的合法性
	{	
        
        if($this->pageNow<0)
		{
			$this->pageNow = 1;
			return 0;
		}
        if(!empty($this->pageCount))
        {
            if($this->pageNow>$this->pageCount)
            {
                $this->pageNow = $this->pageCount;
                return 0;
            }
        }
        
        
        
	}
    public function record_start()
    {
        return (($this->pageNow-1)*$this->pageSize+1);
    }    
    public function record_end()
    {
        return min($this->pageNow*$this->pageSize,$this->rowCount);
    }
       // 首页 
    public function first()
    {   
        if($this->pageNow==1)
        {
           return "{$this->config['first']}&nbsp";
        }else{
          return "<a href='./{$this->uri}?pagenow=1'>{$this->config['first']}</a>&nbsp";
        }
        
    }  
   //尾页    
    public function last()
    {
        if($this->pageNow>=$this->pageCount)
        {
           return "{$this->config['last']}&nbsp";
        }else{
          return "<a href='./{$this->uri}?pagenow={$this->pageCount}'>{$this->config['last']}</a>&nbsp";
        }
    } 
   //  上一页   
    public function prev()
    {		
        if ($this->pageNow > 1) 
        {
            $prepage = $this->pageNow - 1;
            return"<a href='./{$this->uri}?pagenow={$prepage}'>{$this->config['prev']}</a>&nbsp";          
        }
        else{
            return "{$this->config['prev']}&nbsp"; 
        }
    }  
       // 下一页  
    public function next()
    {
   
      if ($this->pageNow < $this->pageCount) 
        {    
            $prepage = $this->pageNow +1 ;
            return"<a href='./{$this->uri}?pagenow={$prepage}'>{$this->config['next']}</a>&nbsp";   
        }
        else{
            return "{$this->config['next']}&nbsp";
        }
   
   
    }
       //  整体滚动  
    public function pagelist()
    {
        $str='';
    // 向前跳$page_whole页 用这个符号表示<< 
		$t =$this->pageNow - $this->page_whole;
		if ($t > 0) {
			$str.= "<a href='./{$this->uri}?pagenow={$t}'><<</a>&nbsp";
		} else {
			//在1-$this->page_whole页中 就没有向前翻动按钮
            $str.='<<&nbsp';
		}
		
		
		// 逐页数 1,2,3,4,5
        //计算左边界
		$minpre = floor(($this->pageNow-1)/($this->page_whole))*$this->page_whole+1;
        //右边界 
		$maxpre = min($minpre -1 + $this->page_whole,$this->pageCount);
		for($i=$minpre;$i<=$maxpre;$i++)
		{

			if($i==$this->pageNow)
			{
				$str.= "{$i}&nbsp";			
			}
			else {
				$str.="<a href='{$this->uri}?pagenow={$i}'>{$i}</a>&nbsp";
			}
		}
		
		// 向后跳$page_whole页
		$t = $this->pageNow  + $this->page_whole;
		
        $minpre_last = floor(($this->pageCount-1)/($this->page_whole))*$this->page_whole+1;
        
        
		if ($minpre >= $minpre_last)
		{ 
			//在$page_whole - $pagecount页 就没没有向前翻动按钮
			//	echo "<a href='music_list.php?pagenow={$pagecount}'>>></a>&nbsp";
            $str.=">>&nbsp";
		}
		else
		{   
            if($t > $this->pageCount)
            {
            $str.= "<a href='./{$this->uri}?pagenow={$minpre}'>>></a>&nbsp";
            }
            else{
            $str.= "<a href='./{$this->uri}?pagenow={$t}'>>></a>&nbsp";
			//echo "<a href='".$yemian."?pagenow={$t}'>>></a>&nbsp";
            }
		}
		
	return $str;
     
     
    }  
    //  跳页
    public function gotopage()
    {   

   $str= "<form action='./{$this->uri}' method='get'>
    <input style='display: block;float: left;' type='text' name='pagenow' placeholder='跳转到' />
        <input style='display: block;float: left;' type='submit' value='GO'>
  
          </form>";
    
    return $str;
    }
    
	//分页导航 方法
	public function nativgate() //设置返回的页面 
	{    

    $str='';
    //共有XX条记录
    $str.="共有<b>{$this->rowCount}</b>{$this->config['header']}&nbsp&nbsp";
    //本页显示XX条记录
    $str.="本页显示<b>".($this->record_end()-$this->record_start()+1)."</b>{$this->config['header']}&nbsp";
    //本页显示第10-20条记录
    $str.="本页显示第<b>{$this->record_start()}</b>-<b>{$this->record_end()}</b>{$this->config['header']}&nbsp&nbsp";    
    //当前页/总共页 例如 5/9页
     $str.="当前页<b>{$this->pageNow}</b>/共<b>{$this->pageCount}</b>页&nbsp&nbsp";
     
   // 首页 上一页   下一页  尾页 整体滚动 
    $str.=$this->first();
    //echo "<a href='XXX.php?pagenow=1'>第一页</a>&nbsp";    
    $str.=$this->prev();
  
    $str.=$this->next();
    $str.=$this->last();   
    $str.=$this->pagelist();  
    //  跳页
    $str.=$this->gotopage();
        
    // 制作
   	return $str;



		
		
		
	}
	
	
	
	//分页导航 方法 带参数
	public function nativgate_get($yemian,$get, $page_whole) //设置返回的页面  设置整体翻动的页数
	{
		if(empty($yemian))
		{
			echo "没有指定返回页面<br>";
		}
	
		if(empty($page_whole))
		{
			echo "没有指定返回页面<br>";
		}
	
		// 制作上一页 下一页
		// 第一页 最后一页
		//echo "<a href='music_list.php?pagenow=1'>第一页</a>&nbsp";
		echo "<a href='".$yemian."?pagenow=1&$get'>第一页</a>&nbsp";
	
	
		if ($this->pageNow > 1) {
			$prepage = $this->pageNow - 1;
	
			echo "<a href='".$yemian."?pagenow=$prepage&$get'>上一页</a>&nbsp";
				
		}
	
		if ($this->pageNow < $this->pageCount) {
			$nextpage = $this->pageNow + 1;
			echo "&nbsp<a href='".$yemian."?pagenow=$nextpage&$get'>下一页</a>&nbsp";
		}
	
		echo "<a href='".$yemian."?pagenow= $this->pageCount&$get'>最后一页</a>&nbsp&nbsp";
	
	
	
	
		// 向前跳$page_whole页
		$t =$this->pageNow  - $page_whole;
		if ($t > 0) {
			echo "<a href='".$yemian."?pagenow={$t}&$get'><<</a>&nbsp";
		} else {
			//在1-$page_whole页 就没没有向前翻动按钮
			// 	echo "<a href='music_list.php?pagenow=1'><<</a>&nbsp";
		}
	
	
		// 逐页数
		$minpre = floor(($this->pageNow  - 1)/$page_whole )*$page_whole+1;
		//$maxpre = ceil($pagenow/$page_whole)*$page_whole;
		$maxpre = $minpre + $page_whole;
		for(;$minpre<$maxpre;$minpre++)
		{
		if($minpre>$this->pageCount||$minpre<1)
		{
		break;
		}
		if($minpre==$this->pageNow)
		{
		echo "<a'>$minpre</a>&nbsp";
		}
		else {
		echo "<a href='".$yemian."?pagenow={$minpre}&$get'>$minpre</a>&nbsp";
		}
		}
	
		// 向后跳$page_whole页
		$t = $this->pageNow  + $page_whole;
	
		if ($t > $this->pageCount)
		{
		//在$page_whole - $pagecount页 就没没有向前翻动按钮
			//	echo "<a href='music_list.php?pagenow={$pagecount}'>>></a>&nbsp";
		}
		else
		{
		echo "<a href='".$yemian."?pagenow={$t}&$get'>>></a>&nbsp";
		}
	
			echo "当前页{$this->pageNow}/共{$this->pageCount}页<br>";
	
	
		}
	
	
	
	
}




?>