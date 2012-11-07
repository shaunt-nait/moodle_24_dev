/******************************************************************************
 FILE: fin-stmts.as
 AUTHOR: Rebecca Marcil
 DATE: Oct.4, 2002
 VERSION: 1.1
 DESCRIPTION: This file contains all the account data used in fin-stmt.fla, and
 			  it is placed on the _root timeline.
******************************************************************************/

//----------------------------------------------------
// Function: CreateFinStmtLvl1Array
// Description: Stores the account names that would go into the ball into a two-D array.
// 				There should be no more than 9 letters of text per line.//
// Input: none
// Pre-Condition: _G_LVL1FINSTMTTOTALTOPICS must match the number of row items in the array
// 			 created by this function.
// Output: Returns a 2D array containing account names for level 1, and their answers.
// Version 1.1 Additions: "subAnswer" is the subAnswer for "Balance Sheet" and could be either
//				Asset, Liability, or Equity
//----------------------------------------------------
function CreateFinStmtLvl1Array() {
        var txtArray = new Array(_G_LVL1FINSTMTTOTALTOPICS);

        for (var i = 0; i < _G_LVL1FINSTMTTOTALTOPICS; i++) {
            txtArray[i] = new Array(4);
        }
        // initializing the array
   		for (var i = 0; i < _G_LVL1FINSTMTTOTALTOPICS; i++) {
        	txtArray[i]["acctName"] = " ";
            txtArray[i]["answer1"] = " ";
        	txtArray[i]["answer2"] = " ";
			txtArray[i]["subAnswer"] = " ";
        }
        txtArray[0]["acctName"] = "\rCash";
        txtArray[0]["answer1"] = "Balance Sheet";
		txtArray[0]["subAnswer"] = "Asset";

        txtArray[1]["acctName"] = "\rEquip.";
        txtArray[1]["answer1"] = "Balance Sheet";
        txtArray[1]["subAnswer"] = "Asset";

        txtArray[2]["acctName"] = "Accounts\rPayable";
        txtArray[2]["answer1"] = "Balance Sheet";
        txtArray[2]["subAnswer"] = "Liability";

        txtArray[3]["acctName"] = "Utilities\rExp.";
        txtArray[3]["answer1"] = "Income Statement";

        txtArray[4]["acctName"] = "Accounts\rReceivable";
        txtArray[4]["answer1"] = "Balance Sheet";
		txtArray[4]["subAnswer"] = "Asset";

        txtArray[5]["acctName"] = "Net\rIncome";
        txtArray[5]["answer1"] = "Income Statement";
        txtArray[5]["answer2"] = "Statement of Owner's Equity";

        txtArray[6]["acctName"] = "Net\rLoss";
        txtArray[6]["answer1"] = "Income Statement";
        txtArray[6]["answer2"] = "Statement of Owner's Equity";

        txtArray[7]["acctName"] = "Capital,\rEnd-of-Period\rBal.";
        txtArray[7]["answer1"] = "Balance Sheet";
        txtArray[7]["subAnswer"] = "S/H Equity";
		txtArray[7]["answer2"] = "Statement of Owner's Equity";

        txtArray[8]["acctName"] = "Capital,\rBeg.-of-Period\rBal.";
        txtArray[8]["answer1"] = "Statement of Owner's Equity";

        txtArray[9]["acctName"] = "\rSupplies";
        txtArray[9]["answer1"] = "Balance Sheet";
        txtArray[9]["subAnswer"] = "Asset";

        txtArray[10]["acctName"] = "\rLand";
        txtArray[10]["answer1"] = "Balance Sheet";
        txtArray[10]["subAnswer"] = "Asset";

        txtArray[11]["acctName"] = "Store\rSupplies";
        txtArray[11]["answer1"] = "Balance Sheet";
		txtArray[11]["subAnswer"] = "Asset";

        txtArray[12]["acctName"] = "Prepaid\rRent";
        txtArray[12]["answer1"] = "Balance Sheet";
        txtArray[12]["subAnswer"] = "Asset";

        txtArray[13]["acctName"] = "Salary\rPayable";
        txtArray[13]["answer1"] = "Balance Sheet";
        txtArray[13]["subAnswer"] = "Liability";

        txtArray[14]["acctName"] = "Interest\rReceivable";
        txtArray[14]["answer1"] = "Balance Sheet";
        txtArray[14]["subAnswer"] = "Asset";

        txtArray[15]["acctName"] = "Rent\rReceivable";
        txtArray[15]["answer1"] = "Balance Sheet";
        txtArray[15]["subAnswer"] = "Asset";

        txtArray[16]["acctName"] = "Mileage\rExp.";
        txtArray[16]["answer1"] = "Income Statement";

        txtArray[17]["acctName"] = "Office\rSupplies";
        txtArray[17]["answer1"] = "Balance Sheet";
        txtArray[17]["subAnswer"] = "Asset";

        txtArray[18]["acctName"] = "Parts\rSupplies";
        txtArray[18]["answer1"] = "Balance Sheet";
        txtArray[18]["subAnswer"] = "Asset";

        txtArray[19]["acctName"] = "Prepaid\rInsurance";
        txtArray[19]["answer1"] = "Balance Sheet";
        txtArray[19]["subAnswer"] = "Asset";

        txtArray[20]["acctName"] = "\rCar";
        txtArray[20]["answer1"] = "Balance Sheet";
        txtArray[20]["subAnswer"] = "Asset";

        txtArray[21]["acctName"] = "Unearned\rRent\rRevenue";
        txtArray[21]["answer1"] = "Balance Sheet";
        txtArray[21]["subAnswer"] = "Liability";

        txtArray[22]["acctName"] = "\rTrucks";
        txtArray[22]["answer1"] = "Balance Sheet";
        txtArray[22]["subAnswer"] = "Asset";

        txtArray[23]["acctName"] = "\rBoats";
        txtArray[23]["answer1"] = "Balance Sheet";
        txtArray[23]["subAnswer"] = "Asset";

        txtArray[24]["acctName"] = "Office\rFurniture";
        txtArray[24]["answer1"] = "Balance Sheet";
        txtArray[24]["subAnswer"] = "Asset";

        txtArray[25]["acctName"] = "\rBuilding";
        txtArray[25]["answer1"] = "Balance Sheet";
        txtArray[25]["subAnswer"] = "Asset";

        txtArray[26]["acctName"] = "Insur.\rPayable";
        txtArray[26]["answer1"] = "Balance Sheet";
        txtArray[26]["subAnswer"] = "Liability";

        txtArray[27]["acctName"] = "Interest\rPayable";
        txtArray[27]["answer1"] = "Balance Sheet";
        txtArray[27]["subAnswer"] = "Liability";

        txtArray[28]["acctName"] = "Rent\rPayable";
        txtArray[28]["answer1"] = "Balance Sheet";
        txtArray[28]["subAnswer"] = "Liability";

        txtArray[29]["acctName"] = "Wages\rPayable";
        txtArray[29]["answer1"] = "Balance Sheet";
		txtArray[29]["subAnswer"] = "Liability";

        txtArray[30]["acctName"] = "Taxes\rPayable";
        txtArray[30]["answer1"] = "Balance Sheet";
        txtArray[30]["subAnswer"] = "Liability";

        txtArray[31]["acctName"] = "PST\rPayable";
        txtArray[31]["answer1"] = "Balance Sheet";
        txtArray[31]["subAnswer"] = "Liability";

        txtArray[32]["acctName"] = "GST\rPayable";
        txtArray[32]["answer1"] = "Balance Sheet";
        txtArray[32]["subAnswer"] = "Liability";

        txtArray[33]["acctName"] = "Fees\rEarned";
        txtArray[33]["answer1"] = "Income Statement";

        txtArray[34]["acctName"] = "\rUnearned\rRevenue";
        txtArray[34]["answer1"] = "Balance Sheet";
        txtArray[34]["subAnswer"] = "Liability";

        txtArray[35]["acctName"] = "\rWithdrawal";
        txtArray[35]["answer1"] = "Statement of Owner's Equity";

        txtArray[36]["acctName"] = "\rRevenue";
        txtArray[36]["answer1"] = "Income Statement";

        txtArray[37]["acctName"] = "Interest\rRevenue";
        txtArray[37]["answer1"] = "Income Statement";

        txtArray[38]["acctName"] = "Rent\rRevenue";
        txtArray[38]["answer1"] = "Income Statement";

        txtArray[39]["acctName"] = "Repairs\rExp.";
        txtArray[39]["answer1"] = "Income Statement";

        txtArray[40]["acctName"] = "Salary\rExp.";
        txtArray[40]["answer1"] = "Income Statement";

        txtArray[41]["acctName"] = "Insur.\rExp.";
        txtArray[41]["answer1"] = "Income Statement";

        txtArray[41]["acctName"] = "Rent\rExp.";
        txtArray[41]["answer1"] = "Income Statement";

        txtArray[42]["acctName"] = "Supplies\rExp.";
        txtArray[42]["answer1"] = "Income Statement";

        txtArray[43]["acctName"] = "Advert.\rExp.";
        txtArray[43]["answer1"] = "Income Statement";

        txtArray[44]["acctName"] = "Fuel\rExp.";
        txtArray[44]["answer1"] = "Income Statement";

        txtArray[45]["acctName"] = "Misc.\rExp.";
        txtArray[45]["answer1"] = "Income Statement";

        txtArray[46]["acctName"] = "Fees\rReceivable";
        txtArray[46]["answer1"] = "Balance Sheet";
        txtArray[46]["subAnswer"] = "Asset";

        txtArray[47]["acctName"] = "Store\rSupplies";
        txtArray[47]["answer1"] = "Balance Sheet";
        txtArray[47]["subAnswer"] = "Asset";

        txtArray[48]["acctName"] = "Prepaid\rInterest";
        txtArray[48]["answer1"] = "Balance Sheet";
        txtArray[48]["subAnswer"] = "Asset";

        txtArray[49]["acctName"] = "Law\rLibrary";
        txtArray[49]["answer1"] = "Balance Sheet";
        txtArray[49]["subAnswer"] = "Asset";

        txtArray[50]["acctName"] = "Office\rEquip.";
        txtArray[50]["answer1"] = "Balance Sheet";
        txtArray[50]["subAnswer"] = "Asset";

        txtArray[51]["acctName"] = "Store\rEquip.";
        txtArray[51]["answer1"] = "Balance Sheet";
        txtArray[51]["subAnswer"] = "Asset";

        txtArray[52]["acctName"] = "\rMachinery";
        txtArray[52]["answer1"] = "Balance Sheet";
        txtArray[52]["subAnswer"] = "Asset";

        txtArray[53]["acctName"] = "Fees\rPayable";
        txtArray[53]["answer1"] = "Balance Sheet";
        txtArray[53]["subAnswer"] = "Liability";

        txtArray[54]["acctName"] = "Salaries\rPayable";
        txtArray[54]["answer1"] = "Balance Sheet";
        txtArray[54]["subAnswer"] = "Liability";

        txtArray[55]["acctName"] = "Office\rSalary\rPayable";
        txtArray[55]["answer1"] = "Balance Sheet";
        txtArray[55]["subAnswer"] = "Liability";

        txtArray[56]["acctName"] = "\rUnearned\rFees";
        txtArray[56]["answer1"] = "Balance Sheet";
        txtArray[56]["subAnswer"] = "Liability";

        txtArray[57]["acctName"] = "Service\rRevenue";
        txtArray[57]["answer1"] = "Income Statement";

        txtArray[58]["acctName"] = "Rent\rEarned";
        txtArray[58]["answer1"] = "Income Statement";

        txtArray[59]["acctName"] = "Interest\rEarned";
        txtArray[59]["answer1"] = "Income Statement";

        txtArray[60]["acctName"] = "Interest\rExp.";
        txtArray[60]["answer1"] = "Income Statement";

        txtArray[61]["acctName"] = "Postage\rExp.";
        txtArray[61]["answer1"] = "Income Statement";

        txtArray[62]["acctName"] = "Property\rTax Exp.";
        txtArray[62]["answer1"] = "Income Statement";

        txtArray[63]["acctName"] = "Travel\rExp.";
        txtArray[63]["answer1"] = "Income Statement";

        txtArray[64]["acctName"] = "Phone\rExp.";
        txtArray[64]["answer1"] = "Income Statement";

        return txtArray;
}
//----------------------------------------------------
// Function: CreateFinStmtLvl2Array
// Description: Stores the account names that would go into the ball into a two-D array
// Input: none
// Pre-Condition: _G_LVL2FINSTMTTOTALTOPICS must match the number of row items in the array
// 			 created by this function.
// Output: Returns a 2D array containing account names for level 2, and their answers.
//----------------------------------------------------
function CreateFinStmtLvl2Array() {
        var txtArray = new Array(_G_LVL2FINSTMTTOTALTOPICS);
		// create the two-D array
        for (var i = 0; i < _G_LVL2FINSTMTTOTALTOPICS; i++) {
        	txtArray[i] = new Array(3);
        }
        // initializing the array
   		for (var i = 0; i < _G_LVL2FINSTMTTOTALTOPICS; i++) {
            txtArray[i]["acctName"] = " ";
        	txtArray[i]["answer1"] = " ";
	        txtArray[i]["subAnswer"] = " ";
        }
        txtArray[0]["acctName"] = "Notes\rReceivable";
        txtArray[0]["answer1"] = "Balance Sheet";
        txtArray[0]["subAnswer"] = "Asset";

        txtArray[1]["acctName"] = "Other\rRevenues &\rExpenses";
        txtArray[1]["answer1"] = "Income Statement";

        txtArray[2]["acctName"] = "Gross\rMargin";
        txtArray[2]["answer1"] = "Income Statement";

        txtArray[3]["acctName"] = "Notes\rPayable";
        txtArray[3]["answer1"] = "Balance Sheet";
        txtArray[3]["subAnswer"] = "Liability";

        txtArray[4]["acctName"] = "Accum.\rAmort.";
        txtArray[4]["answer1"] = "Balance Sheet";
        txtArray[4]["subAnswer"] = "Asset";

        txtArray[5]["acctName"] = "Amort.\rExp.";
        txtArray[5]["answer1"] = "Income Statement";

        txtArray[6]["acctName"] = "\rSales";
        txtArray[6]["answer1"] = "Income Statement";

        txtArray[7]["acctName"] = "Merch.\rInventory";
        txtArray[7]["answer1"] = "Balance Sheet";
        txtArray[7]["subAnswer"] = "Asset";

        txtArray[8]["acctName"] = "Parts\rInventory";
        txtArray[8]["answer1"] = "Balance Sheet";
        txtArray[8]["subAnswer"] = "Asset";

        txtArray[9]["acctName"] = "Sales\rReturns &\rAllow.";
        txtArray[9]["answer1"] = "Income Statement";

        txtArray[10]["acctName"] = "Sales\rDisc.";
        txtArray[10]["answer1"] = "Income Statement";

        txtArray[11]["acctName"] = "Cost\rof Goods\rSold";
        txtArray[11]["answer1"] = "Income Statement";

        txtArray[12]["acctName"] = "Delivery\rExp.";
        txtArray[12]["answer1"] = "Income Statement";

        txtArray[13]["acctName"] = "Current\rAssets";
        txtArray[13]["answer1"] = "Balance Sheet";
		txtArray[13]["subAnswer"] = "Asset";

        txtArray[14]["acctName"] = "Capital\rAssets";
        txtArray[14]["answer1"] = "Balance Sheet";
		txtArray[14]["subAnswer"] = "Asset";

        txtArray[15]["acctName"] = "Total\rOperating\rExp.";
        txtArray[15]["answer1"] = "Income Statement";

        txtArray[16]["acctName"] = "Income\rfrom\rOperations";
        txtArray[16]["answer1"] = "Income Statement";

        txtArray[17]["acctName"] = "\rIntangible\rAssets";
        txtArray[17]["answer1"] = "Balance Sheet";
		txtArray[17]["subAnswer"] = "Asset";

        txtArray[18]["acctName"] = "Admin.\rExp.";
        txtArray[18]["answer1"] = "Income Statement";

        txtArray[19]["acctName"] = "Selling\rExp.";
        txtArray[19]["answer1"] = "Income Statement";

        txtArray[20]["acctName"] = "Current\rLiabilities";
        txtArray[20]["answer1"] = "Balance Sheet";
		txtArray[20]["subAnswer"] = "Liability";

        txtArray[21]["acctName"] = "Gross\rProfit";
        txtArray[21]["answer1"] = "Income Statement";

        txtArray[22]["acctName"] = "Operating\rExp.";
        txtArray[22]["answer1"] = "Income Statement";

        txtArray[23]["acctName"] = "Long\rTerm\rLiabilities";
        txtArray[23]["answer1"] = "Balance Sheet";
		txtArray[23]["subAnswer"] = "Liability";

        txtArray[24]["acctName"] = "Net\rSales";
        txtArray[24]["answer1"] = "Income Statement";

        txtArray[25]["acctName"] = "Long\rTerm\rAssets";
        txtArray[25]["answer1"] = "Balance Sheet";
		txtArray[25]["subAnswer"] = "Asset";

        txtArray[26]["acctName"] = "Selling\rExp.";
        txtArray[26]["answer1"] = "Income Statement";

        txtArray[27]["acctName"] = "Gen. &\rAdmin.\rExp.";
        txtArray[27]["answer1"] = "Income Statement";

        return txtArray;
}
//----------------------------------------------------
// Function: CreateFinStmtLvl3Array
// Description: Stores the account names that would go into the ball into a two-D array
// Input: none
// Pre-Condition: _G_LVL3FINSTMTTOTALTOPICS must match the number of row items in the array
// 			 created by this function.
// Output: Returns a 2D array containing account names for level 3, and their answers.
//----------------------------------------------------
function CreateFinStmtLvl3Array() {
        var txtArray = new Array(_G_LVL3FINSTMTTOTALTOPICS);
		// create the two-D array
        for (var i = 0; i < _G_LVL3FINSTMTTOTALTOPICS; i++) {
     		txtArray[i] = new Array(4);
        }
        // initializing the array
   		for (var i = 0; i < _G_LVL3FINSTMTTOTALTOPICS; i++) {
            txtArray[i]["acctName"] = " ";
        	txtArray[i]["answer1"] = " ";
        	txtArray[i]["answer2"] = " ";
			txtArray[i]["subAnswer"] = " ";
        }
        txtArray[0]["acctName"] = "Petty\rCash";
        txtArray[0]["answer1"] = "Balance Sheet";
		txtArray[0]["subAnswer"] = "Asset";

        txtArray[1]["acctName"] = "Cash\rEquivalent";
        txtArray[1]["answer1"] = "Balance Sheet";
        txtArray[1]["subAnswer"] = "Asset";

        txtArray[2]["acctName"] = "\rAFDA";
        txtArray[2]["answer1"] = "Balance Sheet";
        txtArray[2]["subAnswer"] = "Asset";

        txtArray[3]["acctName"] = "Mineral\rDeposit";
        txtArray[3]["answer1"] = "Balance Sheet";
        txtArray[3]["subAnswer"] = "Asset";

        txtArray[4]["acctName"] = "\rLeaseholds";
        txtArray[4]["answer1"] = "Balance Sheet";
        txtArray[4]["subAnswer"] = "Asset";

        txtArray[5]["acctName"] = "Leasehold\rImprvmts.";
        txtArray[5]["answer1"] = "Balance Sheet";
        txtArray[5]["subAnswer"] = "Asset";

        txtArray[6]["acctName"] = "Land\rImprvmts.";
        txtArray[6]["answer1"] = "Balance Sheet";
        txtArray[6]["subAnswer"] = "Asset";

        txtArray[7]["acctName"] = "\rPatents";
        txtArray[7]["answer1"] = "Balance Sheet";
        txtArray[7]["subAnswer"] = "Asset";

        txtArray[8]["acctName"] = "\rFranchise";
        txtArray[8]["answer1"] = "Balance Sheet";
        txtArray[8]["subAnswer"] = "Asset";

        txtArray[9]["acctName"] = "Org.\rCosts";
        txtArray[9]["answer1"] = "Balance Sheet";
        txtArray[9]["subAnswer"] = "Asset";

        txtArray[10]["acctName"] = "ST Notes\rPayable";
        txtArray[10]["answer1"] = "Balance Sheet";
        txtArray[10]["subAnswer"] = "Liability";

        txtArray[11]["acctName"] = "LT Notes\rPayable";
        txtArray[11]["answer1"] = "Balance Sheet";
        txtArray[11]["subAnswer"] = "Liability";

        txtArray[12]["acctName"] = "Warranty\rLiability";
        txtArray[12]["answer1"] = "Balance Sheet";
        txtArray[12]["subAnswer"] = "Liability";

        txtArray[13]["acctName"] = "Dividend\rPayable";
        txtArray[13]["answer1"] = "Balance Sheet";
        txtArray[13]["subAnswer"] = "Liability";

        txtArray[14]["acctName"] = "UI\rPayable";
        txtArray[14]["answer1"] = "Balance Sheet";
        txtArray[14]["subAnswer"] = "Liability";

        txtArray[15]["acctName"] = "CPP\rPayable";
        txtArray[15]["answer1"] = "Balance Sheet";
        txtArray[15]["subAnswer"] = "Liability";

        txtArray[16]["acctName"] = "Common\rShares";
        txtArray[16]["answer1"] = "Balance Sheet";
        txtArray[16]["subAnswer"] = "S/H Equity";

        txtArray[17]["acctName"] = "C/S\rDividends\rDistrib.";
        txtArray[17]["answer1"] = "Balance Sheet";
        txtArray[17]["subAnswer"] = "S/H Equity";

        txtArray[18]["acctName"] = "Preferred\rShares";
        txtArray[18]["answer1"] = "Balance Sheet";
        txtArray[18]["subAnswer"] = "S/H Equity";

        txtArray[19]["acctName"] = "R/E,\rEnd-of-Period\rBal.";
        txtArray[19]["answer1"] = "Statement of Retained Earnings";
        txtArray[19]["answer2"] = "Balance Sheet";
		txtArray[19]["subAnswer"] = "S/H Equity";

        txtArray[20]["acctName"] = "R/E,\rBeg.-of-Period\rBal.";
        txtArray[20]["answer1"] = "Statement of Retained Earnings";

        txtArray[21]["acctName"] = "Cash\rDividends\rDeclared";
        txtArray[21]["answer1"] = "Statement of Retained Earnings";

        txtArray[22]["acctName"] = "Cash\rOver/Short";
        txtArray[22]["answer1"] = "Income Statement";

        txtArray[23]["acctName"] = "Bad\rDebt\rExp.";
        txtArray[23]["answer1"] = "Income Statement";

        txtArray[24]["acctName"] = "Credit\rCard\rExp.";
        txtArray[24]["answer1"] = "Income Statement";

        txtArray[25]["acctName"] = "Warranty\rExp.";
        txtArray[25]["answer1"] = "Income Statement";

        txtArray[26]["acctName"] = "Gain on\rSale";
        txtArray[26]["answer1"] = "Income Statement";

        txtArray[27]["acctName"] = "Loss on\rSale";
        txtArray[27]["answer1"] = "Income Statement";

        txtArray[28]["acctName"] = "Dividend\rRevenue";
        txtArray[28]["answer1"] = "Income Statement";

        txtArray[29]["acctName"] = "Dividends\rEarned";
        txtArray[29]["answer1"] = "Income Statement";

        txtArray[30]["acctName"] = "Gain on\rDisposal";
        txtArray[30]["answer1"] = "Income Statement";

        txtArray[31]["acctName"] = "Loss on\rDisposal";
        txtArray[31]["answer1"] = "Income Statement";

        txtArray[32]["acctName"] = "Temp.\rInvstmt.";
        txtArray[32]["answer1"] = "Balance Sheet";
        txtArray[32]["subAnswer"] = "Asset";

        txtArray[33]["acctName"] = "\rMarketable\rSecurities";
        txtArray[33]["answer1"] = "Balance Sheet";
        txtArray[33]["subAnswer"] = "Asset";

        txtArray[34]["acctName"] = "Invstmt.\rin\rShares";
        txtArray[34]["answer1"] = "Balance Sheet";
        txtArray[34]["subAnswer"] = "Asset";

        txtArray[35]["acctName"] = "Invstmt.\rin\rBonds";
        txtArray[35]["answer1"] = "Balance Sheet";
        txtArray[35]["subAnswer"] = "Asset";

        txtArray[36]["acctName"] = "Long\rTerm\rInvstmts.";
        txtArray[36]["answer1"] = "Balance Sheet";
        txtArray[36]["subAnswer"] = "Asset";

        txtArray[37]["acctName"] = "Bonds\rPayable";
        txtArray[37]["answer1"] = "Balance Sheet";
        txtArray[37]["subAnswer"] = "Liability";

        txtArray[38]["acctName"] = "Disc.on\rBndsPybl.";
        txtArray[38]["answer1"] = "Balance Sheet";
        txtArray[38]["subAnswer"] = "Liability";

        txtArray[39]["acctName"] = "Premium\ron\rBndsPybl.";
        txtArray[39]["answer1"] = "Balance Sheet";
        txtArray[39]["subAnswer"] = "Liability";

        txtArray[40]["acctName"] = "Share\rDividends\rDeclared";
        txtArray[40]["answer1"] = "Statement of Retained Earnings";

        txtArray[41]["acctName"] = "Cash\rDividends\rDeclared";
        txtArray[41]["answer1"] = "Statement of Retained Earnings";

        return txtArray;
}