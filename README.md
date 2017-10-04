# intervals manipulation in PHP

Library that manages disjointed intervals of integers.

Empty array [] means no interval, it is the default/start state.

The library has three methods:

add(from, to)     - Add an interval
remove(from, to)  - Remove an interval
get()             - List of intervals 

Here is an example sequence:

Start: []
Call: add(1, 5) => [[1, 5]]
Call: remove(2, 3) => [[1, 2], [3, 5]]
Call: add(6, 8) => [[1, 2], [3, 5], [6, 8]]
Call: remove(4, 7) => [[1, 2], [3, 4], [7, 8]]
Call: add(2, 7) => [[1, 8]]

  $myIntervals = new Intervals();
  echo $myIntervals->get() . "\n";
  $myIntervals->add(1, 5);
  echo $myIntervals->get() . "\n";
  $myIntervals->remove(2,3);
  echo $myIntervals->get() . "\n";
  $myIntervals->add(6,8);
  echo $myIntervals->get() . "\n";
  $myIntervals->remove(4,7);
  echo $myIntervals->get() . "\n";
  $myIntervals->add(2,7);
  echo $myIntervals->get() . "\n";
  
will output:

[]
[[1, 5]]
[[1, 2],[3, 5]]
[[1, 2],[3, 5],[6, 8]]
[[1, 2],[3, 4],[7, 8]]
[[1, 8]]
