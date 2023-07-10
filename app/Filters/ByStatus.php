<?php
    namespace App\Filters;

    class ByStatus{
        public function handle($request, \Closure $next)
        {
            $builder = $next($request);
            if(request()->has('status')){
                return $builder->where('status', request()->query('status'));
            }
            return $builder;
        }
    }
?>
