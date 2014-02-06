/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Shamim Ahmed Chowdhury
 */
class InstanceOuter {
  public InstanceOuter(int xx) { x = xx; }

  private int x;

  class InstanceInner {
    public void printSomething() {
      System.out.println("The value of x in my outer is " + x);
    }
  }
}
