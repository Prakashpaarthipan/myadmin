<?php
/*
    class ExecutionTime
    {
         private $startTime;
         private $endTime;

         public function start(){
             $this->startTime = getrusage();
         }

         public function end(){
             $this->endTime = getrusage();
         }

         private function runTime($ru, $rus, $index) {
             return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
         -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
         }    

         public function __toString(){
             return "This process used " . $this->runTime($this->endTime, $this->startTime, "utime") .
            " ms for its computations\nIt spent " . $this->runTime($this->endTime, $this->startTime, "stime") .
            " ms in system calls\n";
         }
     }
     */
      class ExecutionTime
   {
      private $startTime;
      private $endTime;
      private $compTime = 0;
      private $sysTime = 0;

      public function start(){
         $this->startTime = getrusage();
      }

      public function end(){
         $this->endTime = getrusage();
         $this->compTime += $this->runTime($this->endTime, $this->startTime, "utime");
         $this->systemTime += $this->runTime($this->endTime, $this->startTime, "stime");
      }

      private function runTime($ru, $rus, $index) {
         return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
         -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
      }

      public function __toString(){
         return "This process used " . $this->compTime . " ms for its computations\n" .
                "It spent " . $this->systemTime . " ms in system calls\n";
      }
   }
 ?>