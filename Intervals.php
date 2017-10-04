<?php

class Interval
{
  public $to;
  public $from;
  public function __construct($from, $to)
  {
      $this->from = $from;
      $this->to = $to;
  }
}

class Intervals
{

  private $intervals = [];

  public function add($from, $to) {
    $interval = new Interval($from, $to);
    $this->intervals[] = $interval;

    $this->mergeIntervals();
  }

  public function remove($from, $to) {

    $tmpIntervals = [];
    $len = count($this->intervals);
    for ($i=0; $i<$len; $i++) {
        // skip sub is further out
        if ($from > $this->intervals[$i]->to) {
          $tmpIntervals[] = $this->intervals[$i];
          continue;
        // break the sub was before us
        } else if ($to < $this->intervals[$i]->from) {
          $tmpIntervals[] = $this->intervals[$i];
          continue;
        // the sub is completely overlapping this
        } else if ($from <= $this->intervals[$i]->from && $to >= $this->intervals[$i]->to) {
          // skip
        // sub is contained entirely in this one
        } else if ($from >= $this->intervals[$i]->from && $to <= $this->intervals[$i]->to) {
          if ($from > $this->intervals[$i]->from) {
            $tmpInterval = new Interval($this->intervals[$i]->from, $from);
            $tmpIntervals[] = $tmpInterval;
          }
          if ($to < $this->intervals[$i]->to) {
            $tmpInterval = new Interval($to, $this->intervals[$i]->to);
            $tmpIntervals[] = $tmpInterval;
          }
        } else if ($from >= $this->intervals[$i]->from) {
           $tmpInterval = new Interval($this->intervals[$i]->from, $from);
           $tmpIntervals[] = $tmpInterval;
        } else if ($to <= $this->intervals[$i]->to) {
          $tmpInterval = new Interval($to, $this->intervals[$i]->to);
          $tmpIntervals[] = $tmpInterval;
        } e
    }
    $this->intervals = $tmpIntervals;
  }

  public function get() {
    $myIntervals = [];
    foreach($this->intervals as $interval) {
      $myIntervals[] = "[".$interval->from.", ".$interval->to."]";
    }
    $output = "[".implode(",",$myIntervals)."]";
    return $output;
  }

  private function mergeIntervals() {
      $tmp = [];
      $this->sort();

      $n = 0;
      $len = count($this->intervals);
      for ($i=1; $i<$len; ++$i) {
          if ($this->intervals[$i]->from > $this->intervals[$n]->to) {
            $n = $i;
          } else {
            if ($this->intervals[$n]->to < $this->intervals[$i]->to) {
              $this->intervals[$n]->to = $this->intervals[$i]->to;
            }
            unset($this->intervals[$i]);
          }
      }
  }

  // sort two intervals have the same $from, drop the one with the lower $to
  private function sort() {
      usort(
        $this->intervals,
        function ($a, $b) {
            if ($a->from < $b->from) {
              return -1;
            } else if ($a->from > $b->from) {
              return 1;
            } else {
              if ($a->to < $b->to) {
                return -1;
              } else if ($a->to > $b->to) {
                return 1;
              } else {
                return 0;
              }
            }
        }
      );
  }
}

?>
