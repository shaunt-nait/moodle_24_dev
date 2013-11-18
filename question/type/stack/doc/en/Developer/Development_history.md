# History of previous versions of STACK

For current and future plans, see [Development track](Development_track.md) and [Future plans](Future_plans.md).

STACK is a direct development of the CABLE project which ran at the University of Birmingham. CABLE was a development of the AiM computer aided assessment system.

## Version 3.1

Released July 2013. This includes all the bugs found and fixed during the first
year of use at Birmingham, and the first six months at the OU.

Changes since 3.0:

### STACK custom reports

* Split up the answer notes to report back for each PRT separately.
* Introduce "validation notes".  This should work at the PHP level, recording reasons for invalidity.  Since we already connect to the CAS, this should also record whether the student's input is equivalent to the teacher's, in what sense, and what form their answer is in.  Maybe too slow?  Useful perhaps for learning analytics.

### Expanding CAStext features

* Add in support for strings within CASText.  These are currently supported only when the contents is a valid castring, which is overly restrictive.

### Improvements to the editing form

 2. A way to set defaults for many of the options on the question edit form. There are two ways we could do it. We could make it a system-wide setting, controlled by the admin, just like admins can set defaults for all the quiz settings. Alternatively, we could use user_preferences, so the next time you create a STACK question, it uses the same settings as the previous STACK qusetion you created.
 3. Display inputs and PRTs in the order they are mentioned in the question text + specific feedback.
 4. Allow an arbitrary PRT node to be the root node, rather than assuming it is the lowest numbered one.
 5. Display a graphical representation of each PRT, that can be clicked to jump to that Node on the editing form.
 6. When cloning a question with the 'Make copy' button, also clone the question tests.

### Other improvements

* Create a "tidy question" script that can be used to rename Inputs, PRTs and/or Nodes everywhere in a question.
* Add CAStext-enabled ALT tags to the automatically generated images. For example, adding a final, optional, string argument to the "plot" command that the system uses as the ALT text of the image. That way, we can say the function that the graph is of. 
* New option for how inverse trig functions are displayed.
* A script to run question tests in bulk.
* Add a new answer test to deal with decimal places.
* STACK questions with no inputs, and/or no PRTs now work properly.

### Bug fixes

* Fix instant validation for text-area inputs.
* With "Check the type of the response" set to "Yes", if an expression is given and an equation is entered, the error generated is: "Your answer is an equation, but the expression to which it is being compared is not. You may have typed something like "y=2*x+1" when you only needed to type "2*x+1"." This might confuse students. They don't know what " the expression to which it is being compared" is! Perhaps this warning could be reworded something like: "You have entered an equation, but an equation is not expected here. You may have typed something like "y=2*x+1" when you only needed to type "2*x+1"." We should have more messages for each type of failed situation....
* Alt tags in images generated by plots has changed.  The default value now includes a string representation of the function plotted.  See [plots](../CAS/Plots.md#alttext) for more details.
* Assorted other accessibility fixes.
* Standard PRT feedback options are now processed as CAS text.
* There was a bug where clearing the CAS cache broke images in the question text. Now fixed.


## Version 3.0

Released January 2013.  This has been tested successfully for two semesters, with groups of up to 250 university students and a variety of topics.

Major re-engineering of the code by the Open University, The  University of Birmingham and the University of Helsinki.  Documentation added by Ben Holmes.

The most important change is the decision to re-work STACK as a question type for the Moodle quiz.  There is no longer a separate front end for STACK, or (currently) a mechanism to include STACK questions into other websites via a SOAP webservice. This round of development does not plan to introduce major new features, or to make major changes to the core functionality. An explicit aim is that "old questions will still work".

Key features

* __Major difference:__ Integration into the quiz of Moodle 2.3 as a question type.
* Support for Maxima up to 5.28.0.
* Documentation moved from the wiki to within the code base.
* Move from CVS to GIT.

### Changes in features between STACK 2 and STACK 3.

* Key-val pairs, i.e. Question variables and feedback variables, now use Maxima's assignment syntax, e.g. `n:5` not the oldstyle `n=5`.  The importer automtically converts old questions to this new style.
* Interaction elements, now called inputs, are indicated in questions as `[[input:ans1]]` to match the existing style in Moodle.  Existing questions will be converted when imported.
* A number of other terminology changes have brought STACK's use into line with Moodle's, e.g. Worked solution has changed to "general feedback".
* Change in the internal name of one answer test `Equal_Com_ASS` changed to `EqualComASS`.
* Feature "allowed words" dropped from inputs (i.e. interaction elements).
* JSMath is no longer under development, and hence we are no longer providing an option for this in STACK.  However, in STACK 2 we modified JSMath to enable inputs within equations.  Display now assumes the use of a Moodle filter and we recommend (and test with) MathJax, which does not currently support this feature.  If it is important for you to use this feature you will need to copy and modify the load.js file from STACK 2 and use JSMath.
* Worked solution on demand feature has been removed.  This was a hack in STACK 2, and the use of Moodle quiz has made this unnecessary.
* Some options are no longer needed.  This functionality is now handelled by the "behaviours", so are uncecessary in STACK 3.
 * The "Feedback used".
 * The "Mark modification".
* We have lost some of the nice styling on the editing form, compared to Stack 2.
* Answer tests no longer return a numerical mark, hence the "+AT" option for mark modification method has been dropped.
* The STACK maxima function `filter` has been removed.  It should be replaced by the internal Maxima function `sublist`.  Note, the order of the arguments is reversed!
* STACK can now work with either MathJax, the Moodle TeX filter, or the OU's maths rendering filter.
* The maxima libraries `powers` and `format` have been removed.
* We now strongly discourage the use of dollar symbols for denoting LaTeX mathematics environments.  See the pages on [mathjax](MathJax.md#delimiters) for more information on this change.
* The expessions supplied by the question author as question tests are no longer simplified at all.  See the entry on [question tests](../Authoring/Testing.md#Simplification).

### Full development log

#### Milestone 0

1. **DONE** Get STACK in Moodle to connect to Maxima, and clean-up CAS code.
2. **DONE** Moodle-style settings page for STACK's options.
3. **DONE** Re-implement caschat script in Moodle.
4. **DONE** Re-implement healthcheck script in Moodle.
5. **DONE** Make all the answer-tests work in Moodle.
6. **DONE** Make the answer-tests self-test script work in Moodle.
7. **DONE** Make all the input elements work in Moodle.
8. **DONE** Make the input elements self-test script work in Moodle.
9. **DONE** Add all the docs files within the Moodle question type.
10. **DONE** Clean up the PRT code, and make it work within Moodle.
11. **DONE** Code to generate the standard test-_n_ question definitions within Moodle, to help with unit testing.
12. **DONE** Basic Moodle question type that ties all the components together in a basically working form.

#### Milestone 1

1. **DONE** Caching of Maxima results, for performance reasons.
2. **DONE** Database tables to store all aspects of the question definitions.
3. **DONE** Question editing form that can handle multi-input and multi-PRT questions, with validation.
4. **DONE** Re-implement question tests in Moodle.
 1. **DONE** Except that the test input need to be evaluated expressions, not just strings.
5. **DONE** Get deploying, and a fixed number of variants working in Moodle.
6. **DONE** Make multi-part STACK questions work exactly right in Adaptive behaviour.
 1. **DONE** Evaluate some PRTs if possible, even if not all inputs have been filled in.
 2. **DONE** Correct computation of penalty for each PRT, and hence overall final grade.
 3. **DONE** Problem with expressions in feedback CAS-text not being simplified.

#### Milestone 2

1. **DONE** Make sure that STACK questions work as well as possible in the standard Moodle reports.
2. **DONE** Implement the Moodle backup/restore code for stack questions.
3. **DONE** Implement Moodle XML format import and export.
4. **DONE** Investigate ways of running Maxima on a separate server.
5. **DONE** Implement random seed control like for varnumeric.

At this point STACK will be "ready" for use with students, although not all features will be available.

#### Milestone 3

1. **DONE** Finish STACK 2 importer: ensure all fields are imported correctly by the question importer.
2. **DONE** Make STACK respect all Moodle behaviours.
 1. **DONE** Deferred feedback
 2. **DONE** Interactive
 3. **DONE** Deferred feedback with CBM
 4. **DONE** Immediate feedback
 5. **DONE** Immediate feedback with CBM - no unit tests, but if the others work, this one must.
3. **DONE**  Add sample_questions, and update question banks for STACK 3.0.
4. **DONE** Improve the way questions are deployed.
 1. **DONE** Only deploy new versions.
5. **DONE** Editing form: a way to remove a given PRT node.
6. **DONE** Fix bug: penalties and other fields being changed from NULL to 0 when being stored in the database.
7. **DONE** Add back Matrix input type.
9. **DONE** In adaptive mode, display the scoring information for each PRT when it has been evaluated.

Once completed we are ready for the **Beta release!**

#### Beta testing period

1. **DONE** Do lots of testing, report and fix bugs.
2. **DONE** Eliminate as many TODOs from the code as possible.
3. **DONE** Add back other translations from STACK 2.0, preserving as many of the existing strings as possible. NOTE: the new format of the language strings containing parameters.  In particular, strings {$a[0]} need to be changed to {$a->m0}, etc.
4. **DONE** Add back all questions from the diagnostic quiz project as further examples.
5. **DONE** Deploy many versions at once.

#### Editing form

1. **DONE** Form validation should reject a PRT where Node x next -> Node x. Actually, it should validate that we have a connected DAG.
2. **DONE** Add back the help for editing PRT nodes.
3. **DONE** When validating the editing form, actually evaluate the Maxima code.
4. **DONE** When validating the editing form, ensure there are no @ and $ in the fields that expect Maxima code.
5. **DONE** Ensure links from the editing form end up at the STACK docs. This is now work in progress, but relies on http://tracker.moodle.org/browse/MDL-34035 getting accepted into Moodle core. In which case we can use this commit: https://github.com/timhunt/moodle-qtype_stack/compare/helplinks.
6. **DONE** Hide dropdown input type in the editing form until there is a way to set the list of choices.

#### Testing questions

1. **DOES NOT HAPPEN ANY MORE** With a question like test-3, if all the inputs were valid, and then you change the value for some inputs, the corresponding PRTs output the 'Standard feedback for incorrect' when showing the new inputs for the purpose of validation.
2. **DONE** Images added to prt node true or false feedback do not get displayed. There is a missing call to format_text.
3. **DONE** A button on the create test-case form, to fill in the expected results to automatically make a passing test-case.
4. **DONE** Singlechar input should validate that the input is a single char. (There is a TODO in the code for this.)
5. **DONE** Dropdown input should make sure that only allowed values are submitted. (There is a TODO in the code for this.)
6. **DONE** Dropdown input element needs some unit tests. (There is a TODO in the code for this.)
7. **DONE** We need to check for and handle CAS errors in get_prt_result and grade_parts_that_can_be_graded. (There is a TODO in the code for this.)
8. **DONE** Un-comment the throw in the matrix input.
9. **DONE** Unit tests for adative mode score display - and to verify nothing like that appears for other behaviours.
10. **DONE** Duplicate response detection for PRTs should consider all previous responses.
11. **DONE** It appears as if the phrase "This submission attracted a penalty of ..." isn't working.  It looks like this is the *old* penalty, not the *current*.
12. **DONE** PRT node feedback was briefly not being treated as CAS text.
13. **DONE** Improve editing UI for test-cases https://github.com/maths/moodle-qtype_stack/issues/15

##### Optimising Maxima

1. **DONE** Since I have optimized Maxima, I removed write permissions to /moodledata/stack/maximalocal.mac. This makes the healthcheck script unrunnable, and hence I cannot clear the STACK cache.
2. **DONE** Finish off the system for running Maxima on another server (https://github.com/maths/moodle-qtype_stack/pull/8)

##### Documentation system

1. **DONE** fix `maintenance.php`.


## Version 2.2

Released: October 2010 session.

* Enhanced reporting features.
* Enhanced question management features in Moodle.  E.g. [import multiple questions](https://sourceforge.net/tracker/?func=detail&aid=2930512&group_id=119224&atid=683351)
  from AiM/Maple TA at once, assign multiple questions to Moodle question banks.
* Slider interaction elements.

## Version 2.1

Developed by Chris Sangwin and Simon Hammond at the University of Birmingham.
Released: Easter 2010 session.

Key features

* [Precision](../Authoring/Answer_tests.md#Precision) answer test added to allow significant to be checked.
* [Form](../Authoring/Answer_tests.md#Form) answer test added to test if an expression is in completed square form.
* List interaction element expanded to include checkboxes.  See [List](../Authoring/Inputs.md#List).
* Move to Maxima's `random()` function, rather then generate our own pseudo random numbers
* [Conditionals in CASText](https://sourceforge.net/tracker/?func=detail&aid=2888054&group_id=119224&atid=683351)
* Support for Maxima 5.20.1
* New option added: OptWorkedSol.  This allows the teacher to decide whether the tick box to request the worked solution is available.
* Sample resources included as part of the FETLAR project.


## Version 2.0

Released, September 2007.  Developed by Jonathan Hart and Chris Sangwin at the University of Birmingham.

Key features

* Display of mathematics taken care of by JSMath.
* Integrated into Moodle.
* Variety of interaction elements.
* Multi-part questions.
* Cache.
* Item tests.

### Version 1.0

Released, 2005.  Developed by Chris Sangwin at the University of Birmingham.