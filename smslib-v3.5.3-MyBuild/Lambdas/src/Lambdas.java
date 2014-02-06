/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Shamim Ahmed Chowdhury
 */
public class Lambdas {
  public static void main(String... args) {
    Runnable r = () -> {
        System.out.println("Howdy, world!");
    };
    r.run();
  }
}
