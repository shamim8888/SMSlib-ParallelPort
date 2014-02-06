/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Shamim Ahmed Chowdhury
 */
public class InnerClassExamples {
  public static void main(String... args) {
    InstanceOuter io = new InstanceOuter(12);

    // Is this a compile error?
    InstanceOuter.InstanceInner ii = io.new InstanceInner();

    // What does this print?
    ii.printSomething(); // prints 12

    // What about this?
    StaticOuter.StaticInner si = new StaticOuter.StaticInner();
    si.printSomething(); // prints 24
  }
}
