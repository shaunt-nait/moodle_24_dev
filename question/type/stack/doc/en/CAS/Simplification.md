# Simplification

The level of simplification performed by Maxima can be controlled by changing Maxima's global variable `simp`, e.g.

    simp:true

This variable can be set at the question level using the [options](../Authoring/Options.md) or for each [Potential response tree](../Authoring/Potential_response_trees.md).

When this is `false`, no simplification is performed and Maxima is quite happy to deal with an expression such as \(1+4\) without actually performing the addition.
This is most useful for dealing with very elementary expressions.

## Selective simplification

If you are using `simp:false` to evaluate an expression with simplification on you can use

    ev(ex,simp)

## Unary minus and simplification

There are still some problems with the unary minus, e.g. sometimes we get the display \(4+(-3x)\) when we would actually like to always display as \(4-3x\).  This is a problem with the unary minus function `-(x)` as compared to binary infix subtraction `a-b`.

To reproduce this problem type in the following into a Maxima session:

    simp:false;
    p:y^3-2*y^2-8*y;

This displays the polynomial as follows.

    y^3-2*y^2+(-8)*y

Notice the first subtraction is fine, but the second one is not.  To understand this, we can view the internal tree structure of the expression by typing in

    ?print(p);
    ((MPLUS) ((MEXPT) $Y 3) ((MMINUS) ((MTIMES) 2 ((MEXPT) $Y 2))) ((MTIMES) ((MMINUS) 8) $Y))
   
In the structure of this expression the first negative coefficient is `-(2*y^2)` BUT the second is `-(8)*y`.   This again is a crucial but subtle difference!  To address this issue we have a function
   
    unary_minus_sort(p);

which pulls "-" out the front in a specific situation: that of a product with a negative number at the front.  The result here is the anticipated `y^3-2*y^2-8*y`.

Note that STACK's display functions automatically apply `unary_minus_sort(...)` to any expression being displayed. 

## Further examples

Some further examples are given elsewhere:

* Matrix examples in [showing working](Matrix.md#Showing_working).
* An example of a question with `simp:false` is discussed in [authoring quick start 3](../Authoring/Authoring_quick_start_3.md).
* Generating [random algebraic expressions](Random.md) which need to be "gathered and sorted".

Note also that [question tests](../Authoring/Testing.md#Simplification) do not simplify test inputs.
