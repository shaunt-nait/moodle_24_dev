# CASText

## Introduction ##

CASText is CAS-enabled text.  CASText is simply HTML into which LaTeX mathematics and CAS commands can be embedded. These CAS commands are executed before the question is displayed to the user. _Use only simple LaTeX mathematics structures_. Only a small part of core LaTeX is supported.

Many of the fields in a STACK question, such as the question text, are of this type.

Information about [Basic HTML](http://www.w3schools.com/html/html_primary.asp) is available elsewhere.

Currently STACK does not process the LaTeX itself.  It is displayed on the user's browser in a variety of ways, such as using [MathJAX](http://http://www.mathjax.org/).   If you do not know how to use LaTeX, some simple examples are given in the [author FAQ](Author_FAQ.md).

The following things to remember about CASText:

* Anything enclosed between `\( .... \)` symbols is treated as an _inline equation_, as is the case with normal LaTeX.  
* Anything enclosed between matching `\[` and `\]` is treated as a _displayed equation_, in the centre of a new line. Again, this is the case with LaTeX.
* We strongly discourage the use of dollar symbols such as `$...$` and `$$...$$` for denoting LaTeX mathematics environments.  See the notes on [currency](CASText.md#currency) below and also the page on [mathjax](../Developer/MathJax.md#delimiters) for more information.
* Don't use LaTeX text formatting features such as `\\`, instead use the HTML versions.
* Anything enclosed between `@` symbols is evaluated by the CAS and replaced by the LaTeX representing the result.  Some notes.
 * By default this is displayed as an _inline equation_.  This is analogous to using LaTeX symbols. Note however, that you don't need to use `\(@ stuff @\)`, and that `@ stuff @` is sufficient.
 * To get a displayed equation centred on a line of its own, you must use `\[@ stuff @\]`, as in LaTeX.
* Multiple CAS expressions may appear in a single LaTeX equation, as needed.  For example `\[  \frac{@p@}{@q@} \]`.  Note that many problems are _best solved_ at the level of the CAS, e.g. by defining a variable `p/q` in the CAS, not at the level of display.  This is a design decision which needs experience to resolve efficiently in each case.  For an example of this, see the example [showing working](../CAS/Matrix.md#Showing_working).

Here is an example

    The derivative of @ x^4/(1+x^4) @ is
    \[ \frac{d}{dx} \frac{x^4}{1+x^4} = @ diff(x^4/(1+x^4),x) @ \]


## Variables ##   {#Variables}

CASText may depend on variables previously defined in the [question variables](KeyVals.md#Question_variables) field.

Where the CASText appears in the fields of a [potential response trees](Potential_response_trees.md),
the variables in the [feedback variables](KeyVals.md#Feedback_variables) may also be included.

## Question text {#question_text}

The question text what the student actually sees.  This was called "question text" in previous versions.

It is a slightly modified form of CAS text.  To allow a student to answer a question you must include an [inputs](Inputs.md) in the question text. For example, students need a box into which their answer will be put.

To place an [inputs](Inputs.md) into the question enclose the
name of the [Maxima](../CAS/Maxima.md) variable to which the student's answer is assigned between hash symbols, e.g. `#ans1#`

When the question is created this is replaced with the appropriate [inputs](Inputs.md).
When the student answers, this variable name is available to each [potential response trees](Potential_response_trees.md).

Feedback can be included anywhere within the question text.

* When you create an [inputs](Inputs.md) STACK automatically adds
  a string such as the following.  `<IEfeedback>ans1</IEfeedback>`
* When you create a [potential response trees](Potential_response_trees.md) STACK automatically adds
  a string such as the following `<PRTfeedback>1</PRTfeedback>`

These strings are replaced by appropriate feedback as necessary.
They can be moved anywhere within the question text.
Do **not** place feedback within LaTeX equations!

## General feedback/Worked solution {#general_feedback}

General feedback (called "worked solution" in previous versions) is shown to the student after they have attempted the question. Unlike feedback, which depends on the response the student gave, the same general feedback text is shown to all students.

The general feedback may depend on any question variables, but may _not_ depend on any of the inputs.
While this design decision is restrictive, it is a deliberate separation of feedback
which should be done via potential response trees, from a model solution to this
problem which can be written before a question is deployed.

## CASText and currency {#currency}

It is common to want to use the dollar sign for currency.  However, this conflicts with the use of the dollar sign for delimiters for mathematics.  For this reason we discourage the use of dollars to delimit mathematics in STACK.

* If you are using dollars for currency then you must protect them with a backslash, i.e. `\$`, otherwise the CASText validation will fail.

## Most useful HTML ##

HTML Paragraphs (don't forget the end tag!)

    <p>This is a paragraph</p>
    <p>This is another paragraph</p>

HTML Line Breaks

Use the `<br />` tag if you want a line break (a new line) without starting a new paragraph:

    <p>This is<br />a para<br />graph with line breaks</p>

Some formatting

    <em>This is emphasis</em>

    <b>This text is bold</b>

    <big>This text is big</big>

    <i>This text is italic</i>

    <code>This is computer output</code>

    This is <sub>subscript</sub> and <sup>superscript</sup>

## Useful LaTeX ##

LaTeX notation can specify inline or display mode for maths by delimiting with `\(` or `\[` respectively.  Here are some simple examples:

* `x^2` gives \(x^2\)
* `x_n` gives \(x_n\)
* `x^{2x}` gives \(x^{2x}\)
* `\alpha\beta` gives \(\alpha\beta\)
* `\sin(3\pi x)` gives \(\sin(3\pi x)\)
* `\frac{1}{1-n^2}` gives \(\frac{1}{1-n^2}\) when inline.  In display mode it gives:

\[ \frac{1}{1-n^2} \]

* `\int_a^b x^2\ dx` gives \(\int_a^b x^2\ dx\) when inline.  In display mode it gives:

\[ \int_a^b x^2\ dx \]

There is a specific page for [actuarial notation](Actuarial.md).

## Google Charts ##

The [Google charts](http://code.google.com/apis/chart/) API can be used to create a URL based on the random variables.

![](http://chart.apis.google.com/chart?cht=v&chs=200x100&chd=t:100,100,0,50&chdl=A|B)

Details are given in the section on [plots](../CAS/Plots.md#google).

