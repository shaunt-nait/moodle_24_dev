/******************************************************************************
 FILE: dr-cr.as
 AUTHOR: Rebecca Marcil
 DATE: Aug. 27, 2002
 VERSION: 1.0  
 DESCRIPTION: This file contains all the account data used in dr-cr.fla, and 
 			  it is placed on the _root timeline.
******************************************************************************/

//----------------------------------------------------
// Function: CreateDrCrLvl1Array
// Description: used by the _root timeline of drcr.fla.
// Pre-Condition:  _G_LVL1DRCRTOTALTOPICS must match the number of row items in the array
// 			 created by this function.***
// Output: Returns the array with all the account names for level 1.
//----------------------------------------------------
function CreateDrCrLvl1Array() {
	var txtArray = new Array(_G_LVL1DRCRTOTALTOPICS);
	
	for (var i = 0; i < _G_LVL1DRCRTOTALTOPICS; i++) {
		txtArray[i] = new Array(3);
	}
	txtArray[0]["acctName"] = "Cash";
	txtArray[0]["answer"] = "debit";
	txtArray[0]["status"] = "increasing";

	txtArray[1]["acctName"] = "Cash";
	txtArray[1]["answer"] = "credit";
	txtArray[1]["status"] = "decreasing";

	txtArray[2]["acctName"] = "Cash";
	txtArray[2]["answer"] = "debit";
	txtArray[2]["status"] = "normal";
	
	txtArray[3]["acctName"] = "Equip.";
	txtArray[3]["answer"] = "debit";
	txtArray[3]["status"] = "increasing";
	
	txtArray[4]["acctName"] = "Equip.";
	txtArray[4]["answer"] = "credit";
	txtArray[4]["status"] = "decreasing";	

	txtArray[5]["acctName"] = "Equip.";
	txtArray[5]["answer"] = "debit";
	txtArray[5]["status"] = "normal";	
	
	txtArray[6]["acctName"] = "Accounts\rPayable";
	txtArray[6]["answer"] = "credit";
	txtArray[6]["status"] = "increasing";				

	txtArray[7]["acctName"] = "Accounts\rPayable";
	txtArray[7]["answer"] = "debit";
	txtArray[7]["status"] = "decreasing";	
		
	txtArray[8]["acctName"] = "Accounts\rPayable";
	txtArray[8]["answer"] = "credit";
	txtArray[8]["status"] = "normal";	

	txtArray[9]["acctName"] = "Utilities\rExp.";
	txtArray[9]["answer"] = "debit";
	txtArray[9]["status"] = "increasing";	
	
	txtArray[10]["acctName"] = "Utilities\rExp.";
	txtArray[10]["answer"] = "credit";
	txtArray[10]["status"] = "decreasing";	
	
	txtArray[11]["acctName"] = "Utilities\rExp.";
	txtArray[11]["answer"] = "debit";
	txtArray[11]["status"] = "normal";	
	
	txtArray[12]["acctName"] = "Accounts\rReceivable";
	txtArray[12]["answer"] = "debit";
	txtArray[12]["status"] = "increasing";	
	
	txtArray[13]["acctName"] = "Accounts\rReceivable";
	txtArray[13]["answer"] = "credit";
	txtArray[13]["status"] = "decreasing";							
	
	txtArray[14]["acctName"] = "Accounts\rReceivable";
	txtArray[14]["answer"] = "debit";
	txtArray[14]["status"] = "normal";							
	
	txtArray[15]["acctName"] = "Supplies";
	txtArray[15]["answer"] = "debit";
	txtArray[15]["status"] = "increasing";	
	
	txtArray[16]["acctName"] = "Supplies";
	txtArray[16]["answer"] = "credit";
	txtArray[16]["status"] = "decreasing";	

	txtArray[17]["acctName"] = "Supplies";
	txtArray[17]["answer"] = "debit";
	txtArray[17]["status"] = "normal";	
	
	txtArray[18]["acctName"] = "Land";
	txtArray[18]["answer"] = "debit";
	txtArray[18]["status"] = "increasing";	
	
	txtArray[19]["acctName"] = "Land";
	txtArray[19]["answer"] = "credit";
	txtArray[19]["status"] = "decreasing";	
	
	txtArray[20]["acctName"] = "Land";
	txtArray[20]["answer"] = "debit";
	txtArray[20]["status"] = "normal";	
	
	txtArray[21]["acctName"] = "Capital";
	txtArray[21]["answer"] = "credit";
	txtArray[21]["status"] = "increasing";	
	
	txtArray[22]["acctName"] = "Capital";
	txtArray[22]["answer"] = "debit";
	txtArray[22]["status"] = "decreasing";										

	txtArray[23]["acctName"] = "Capital";
	txtArray[23]["answer"] = "credit";
	txtArray[23]["status"] = "normal";										
	
	txtArray[24]["acctName"] = "Store\rSupplies";
	txtArray[24]["answer"] = "debit";
	txtArray[24]["status"] = "increasing";										
	
	txtArray[25]["acctName"] = "Store\rSupplies";
	txtArray[25]["answer"] = "credit";
	txtArray[25]["status"] = "decreasing";													
	
	txtArray[26]["acctName"] = "Store\rSupplies";
	txtArray[26]["answer"] = "debit";
	txtArray[26]["status"] = "normal";	
	
	txtArray[27]["acctName"] = "Prepaid\rRent";
	txtArray[27]["answer"] = "debit";
	txtArray[27]["status"] = "increasing";
	
	txtArray[28]["acctName"] = "Prepaid\rRent";
	txtArray[28]["answer"] = "credit";
	txtArray[28]["status"] = "decreasing";
	
	txtArray[29]["acctName"] = "Prepaid\rRent";
	txtArray[29]["answer"] = "debit";
	txtArray[29]["status"] = "normal";
	
	txtArray[30]["acctName"] = "Salary\rPayable";
	txtArray[30]["answer"] = "credit";
	txtArray[30]["status"] = "increasing";
	
	txtArray[31]["acctName"] = "Salary\rPayable";
	txtArray[31]["answer"] = "debit";
	txtArray[31]["status"] = "decreasing";
	
	txtArray[32]["acctName"] = "Salary\rPayable";
	txtArray[32]["answer"] = "credit";
	txtArray[32]["status"] = "normal";
	
	txtArray[33]["acctName"] = "Interest\rReceivable";
	txtArray[33]["answer"] = "debit";
	txtArray[33]["status"] = "increasing";
	
	txtArray[34]["acctName"] = "Interest\rReceivable";
	txtArray[34]["answer"] = "credit";
	txtArray[34]["status"] = "decreasing";	
	
	txtArray[35]["acctName"] = "Interest\rReceivable";
	txtArray[35]["answer"] = "debit";
	txtArray[35]["status"] = "normal";	
	
	txtArray[36]["acctName"] = "Rent\rReceivable";
	txtArray[36]["answer"] = "debit";
	txtArray[36]["status"] = "increasing";	
	
	txtArray[37]["acctName"] = "Rent\rReceivable";
	txtArray[37]["answer"] = "credit";
	txtArray[37]["status"] = "decreasing";	

	txtArray[38]["acctName"] = "Rent\rReceivable";
	txtArray[38]["answer"] = "debit";
	txtArray[38]["status"] = "normal";

	txtArray[39]["acctName"] = "Mileage\rExp.";
	txtArray[39]["answer"] = "debit";
	txtArray[39]["status"] = "increasing";													

	txtArray[40]["acctName"] = "Mileage\rExp.";
	txtArray[40]["answer"] = "credit";
	txtArray[40]["status"] = "decreasing";		

	txtArray[41]["acctName"] = "Mileage\rExp.";
	txtArray[41]["answer"] = "debit";
	txtArray[41]["status"] = "normal";	

	txtArray[42]["acctName"] = "Office\rSupplies";
	txtArray[42]["answer"] = "debit";
	txtArray[42]["status"] = "increasing";	

	txtArray[43]["acctName"] = "Office\rSupplies";
	txtArray[43]["answer"] = "credit";
	txtArray[43]["status"] = "decreasing";				

	txtArray[44]["acctName"] = "Office\rSupplies";
	txtArray[44]["answer"] = "debit";
	txtArray[44]["status"] = "normal";	

	txtArray[45]["acctName"] = "Parts\rSupplies";
	txtArray[45]["answer"] = "debit";
	txtArray[45]["status"] = "increasing";	

	txtArray[46]["acctName"] = "Parts\rSupplies";
	txtArray[46]["answer"] = "credit";
	txtArray[46]["status"] = "decreasing";	

	txtArray[47]["acctName"] = "Parts\rSupplies";
	txtArray[47]["answer"] = "debit";
	txtArray[47]["status"] = "normal";	

	txtArray[48]["acctName"] = "Prepaid\rInsurance";
	txtArray[48]["answer"] = "debit";
	txtArray[48]["status"] = "increasing";						

	txtArray[49]["acctName"] = "Prepaid\rInsurance";
	txtArray[49]["answer"] = "credit";
	txtArray[49]["status"] = "decreasing";		

	txtArray[50]["acctName"] = "Prepaid\rInsurance";
	txtArray[50]["answer"] = "debit";
	txtArray[50]["status"] = "normal";	

	txtArray[51]["acctName"] = "Car";
	txtArray[51]["answer"] = "debit";
	txtArray[51]["status"] = "increasing";	

	txtArray[52]["acctName"] = "Car";
	txtArray[52]["answer"] = "credit";
	txtArray[52]["status"] = "decreasing";	

	txtArray[53]["acctName"] = "Car";
	txtArray[53]["answer"] = "debit";
	txtArray[53]["status"] = "normal";	

	txtArray[54]["acctName"] = "Unearned\rRent Rev.";
	txtArray[54]["answer"] = "credit";
	txtArray[54]["status"] = "increasing";	
	
	txtArray[55]["acctName"] = "Unearned\rRent Rev.";
	txtArray[55]["answer"] = "debit";
	txtArray[55]["status"] = "decreasing";							
	
	txtArray[56]["acctName"] = "Unearned\rRent Rev.";
	txtArray[56]["answer"] = "credit";
	txtArray[56]["status"] = "normal";							
	
	txtArray[57]["acctName"] = "Trucks";
	txtArray[57]["answer"] = "debit";
	txtArray[57]["status"] = "increasing";							
	
	txtArray[58]["acctName"] = "Trucks";
	txtArray[58]["answer"] = "credit";
	txtArray[58]["status"] = "decreasing";										
	
	txtArray[59]["acctName"] = "Trucks";
	txtArray[59]["answer"] = "debit";
	txtArray[59]["status"] = "normal";	
	
	txtArray[60]["acctName"] = "Boats";
	txtArray[60]["answer"] = "debit";
	txtArray[60]["status"] = "increasing";	

	txtArray[61]["acctName"] = "Boats";
	txtArray[61]["answer"] = "credit";
	txtArray[61]["status"] = "decreasing";				

	txtArray[62]["acctName"] = "Boats";
	txtArray[62]["answer"] = "debit";
	txtArray[62]["status"] = "normal";		

	txtArray[63]["acctName"] = "Office\rFurniture";
	txtArray[63]["answer"] = "debit";
	txtArray[63]["status"] = "increasing";		

	txtArray[64]["acctName"] = "Office\rFurniture";
	txtArray[64]["answer"] = "credit";
	txtArray[64]["status"] = "decreasing";	

	txtArray[65]["acctName"] = "Office\rFurniture";
	txtArray[65]["answer"] = "debit";
	txtArray[65]["status"] = "normal";	

	txtArray[66]["acctName"] = "Building";
	txtArray[66]["answer"] = "debit";
	txtArray[66]["status"] = "increasing";	

	txtArray[67]["acctName"] = "Building";
	txtArray[67]["answer"] = "credit";
	txtArray[67]["status"] = "decreasing";	

	txtArray[68]["acctName"] = "Building";
	txtArray[68]["answer"] = "debit";
	txtArray[68]["status"] = "normal";	

	txtArray[69]["acctName"] = "Insurance\rPayable";
	txtArray[69]["answer"] = "credit";
	txtArray[69]["status"] = "increasing";									

	txtArray[70]["acctName"] = "Insurance\rPayable";
	txtArray[70]["answer"] = "debit";
	txtArray[70]["status"] = "decreasing";									

	txtArray[71]["acctName"] = "Insurance\rPayable";
	txtArray[71]["answer"] = "credit";
	txtArray[71]["status"] = "normal";									

	txtArray[72]["acctName"] = "Interest\rPayable";
	txtArray[72]["answer"] = "credit";
	txtArray[72]["status"] = "increasing";	

	txtArray[73]["acctName"] = "Interest\rPayable";
	txtArray[73]["answer"] = "debit";
	txtArray[73]["status"] = "decreasing";	

	txtArray[74]["acctName"] = "Interest\rPayable";
	txtArray[74]["answer"] = "credit";
	txtArray[74]["status"] = "normal";	

	txtArray[75]["acctName"] = "Rent\rPayable";
	txtArray[75]["answer"] = "credit";
	txtArray[75]["status"] = "increasing";	

	txtArray[76]["acctName"] = "Rent\rPayable";
	txtArray[76]["answer"] = "debit";
	txtArray[76]["status"] = "decreasing";	

	txtArray[77]["acctName"] = "Rent\rPayable";
	txtArray[77]["answer"] = "credit";
	txtArray[77]["status"] = "normal";	

	txtArray[78]["acctName"] = "Wages\rPayable";
	txtArray[78]["answer"] = "credit";
	txtArray[78]["status"] = "increasing";	

	txtArray[79]["acctName"] = "Wages\rPayable";
	txtArray[79]["answer"] = "debit";
	txtArray[79]["status"] = "decreasing";

	txtArray[80]["acctName"] = "Wages\rPayable";
	txtArray[80]["answer"] = "credit";
	txtArray[80]["status"] = "normal";

	txtArray[81]["acctName"] = "Taxes\rPayable";
	txtArray[81]["answer"] = "credit";
	txtArray[81]["status"] = "increasing";

	txtArray[82]["acctName"] = "Taxes\rPayable";
	txtArray[82]["answer"] = "debit";
	txtArray[82]["status"] = "decreasing";

	txtArray[83]["acctName"] = "Taxes\rPayable";
	txtArray[83]["answer"] = "credit";
	txtArray[83]["status"] = "normal";

	txtArray[84]["acctName"] = "PST\rPayable";
	txtArray[84]["answer"] = "credit";
	txtArray[84]["status"] = "increasing";

	txtArray[85]["acctName"] = "PST\rPayable";
	txtArray[85]["answer"] = "debit";
	txtArray[85]["status"] = "decreasing";

	txtArray[86]["acctName"] = "PST\rPayable";
	txtArray[86]["answer"] = "credit";
	txtArray[86]["status"] = "normal";

	txtArray[87]["acctName"] = "GST\rPayable";
	txtArray[87]["answer"] = "credit";
	txtArray[87]["status"] = "increasing";

	txtArray[88]["acctName"] = "GST\rPayable";
	txtArray[88]["answer"] = "debit";
	txtArray[88]["status"] = "decreasing";

	txtArray[89]["acctName"] = "GST\rPayable";
	txtArray[89]["answer"] = "credit";
	txtArray[89]["status"] = "normal";											

	txtArray[90]["acctName"] = "Fees\rEarned";
	txtArray[90]["answer"] = "credit";
	txtArray[90]["status"] = "increasing";

	txtArray[91]["acctName"] = "Fees\rEarned";
	txtArray[91]["answer"] = "debit";
	txtArray[91]["status"] = "decreasing";

	txtArray[92]["acctName"] = "Fees\rEarned";
	txtArray[92]["answer"] = "credit";
	txtArray[92]["status"] = "normal";																

	txtArray[93]["acctName"] = "Unearned\rRevenue";
	txtArray[93]["answer"] = "credit";
	txtArray[93]["status"] = "increasing";

	txtArray[94]["acctName"] = "Unearned\rRevenue";
	txtArray[94]["answer"] = "debit";
	txtArray[94]["status"] = "decreasing";

	txtArray[95]["acctName"] = "Unearned\rRevenue";
	txtArray[95]["answer"] = "credit";
	txtArray[95]["status"] = "normal";	
	
	txtArray[96]["acctName"] = "\rWithdrawal";
	txtArray[96]["answer"] = "debit";
	txtArray[96]["status"] = "increasing";

	txtArray[97]["acctName"] = "\rWithdrawal";
	txtArray[97]["answer"] = "credit";
	txtArray[97]["status"] = "decreasing";

	txtArray[98]["acctName"] = "\rWithdrawal";
	txtArray[98]["answer"] = "debit";
	txtArray[98]["status"] = "normal";	

	txtArray[99]["acctName"] = "Revenue";
	txtArray[99]["answer"] = "credit";
	txtArray[99]["status"] = "increasing";

	txtArray[100]["acctName"] = "Revenue";
	txtArray[100]["answer"] = "debit";
	txtArray[100]["status"] = "decreasing";

	txtArray[101]["acctName"] = "Revenue";
	txtArray[101]["answer"] = "credit";
	txtArray[101]["status"] = "normal";	

	txtArray[102]["acctName"] = "Interest\rRevenue";
	txtArray[102]["answer"] = "credit";
	txtArray[102]["status"] = "increasing";

	txtArray[103]["acctName"] = "Interest\rRevenue";
	txtArray[103]["answer"] = "debit";
	txtArray[103]["status"] = "decreasing";

	txtArray[104]["acctName"] = "Interest\rRevenue";
	txtArray[104]["answer"] = "credit";
	txtArray[104]["status"] = "normal";	

	txtArray[105]["acctName"] = "Rent\rRevenue";
	txtArray[105]["answer"] = "credit";
	txtArray[105]["status"] = "increasing";

	txtArray[106]["acctName"] = "Rent\rRevenue";
	txtArray[106]["answer"] = "debit";
	txtArray[106]["status"] = "decreasing";

	txtArray[107]["acctName"] = "Rent\rRevenue";
	txtArray[107]["answer"] = "credit";
	txtArray[107]["status"] = "normal";	

	txtArray[108]["acctName"] = "Repairs\rExp.";
	txtArray[108]["answer"] = "debit";
	txtArray[108]["status"] = "increasing";

	txtArray[109]["acctName"] = "Repairs\rExp.";
	txtArray[109]["answer"] = "credit";
	txtArray[109]["status"] = "decreasing";

	txtArray[110]["acctName"] = "Repairs\rExp.";
	txtArray[110]["answer"] = "debit";
	txtArray[110]["status"] = "normal";				

	txtArray[111]["acctName"] = "Salary\rExp.";
	txtArray[111]["answer"] = "debit";
	txtArray[111]["status"] = "increasing";

	txtArray[112]["acctName"] = "Salary\rExp.";
	txtArray[112]["answer"] = "credit";
	txtArray[112]["status"] = "decreasing";

	txtArray[113]["acctName"] = "Salary\rExp.";
	txtArray[113]["answer"] = "debit";
	txtArray[113]["status"] = "normal";	

	txtArray[114]["acctName"] = "Insurance\rExp.";
	txtArray[114]["answer"] = "debit";
	txtArray[114]["status"] = "increasing";

	txtArray[115]["acctName"] = "Insurance\rExp.";
	txtArray[115]["answer"] = "credit";
	txtArray[115]["status"] = "decreasing";

	txtArray[116]["acctName"] = "Insurance\rExp.";
	txtArray[116]["answer"] = "debit";
	txtArray[116]["status"] = "normal";		

	txtArray[117]["acctName"] = "Rent\rExp.";
	txtArray[117]["answer"] = "debit";
	txtArray[117]["status"] = "increasing";

	txtArray[118]["acctName"] = "Rent\rExp.";
	txtArray[118]["answer"] = "credit";
	txtArray[118]["status"] = "decreasing";

	txtArray[119]["acctName"] = "Rent\rExp.";
	txtArray[119]["answer"] = "debit";
	txtArray[119]["status"] = "normal";		

	txtArray[120]["acctName"] = "Supply\rExp.";
	txtArray[120]["answer"] = "debit";
	txtArray[120]["status"] = "increasing";
	
	txtArray[121]["acctName"] = "Supply\rExp.";
	txtArray[121]["answer"] = "credit";
	txtArray[121]["status"] = "decreasing";

	txtArray[122]["acctName"] = "Supply\rExp.";
	txtArray[122]["answer"] = "debit";
	txtArray[122]["status"] = "normal";				

	txtArray[123]["acctName"] = "Advert.\rExp.";
	txtArray[123]["answer"] = "debit";
	txtArray[123]["status"] = "increasing";
	
	txtArray[124]["acctName"] = "Advert.\rExp.";
	txtArray[124]["answer"] = "credit";
	txtArray[124]["status"] = "decreasing";

	txtArray[125]["acctName"] = "Advert.\rExp.";
	txtArray[125]["answer"] = "debit";
	txtArray[125]["status"] = "normal";	

	txtArray[126]["acctName"] = "Fuel\rExp.";
	txtArray[126]["answer"] = "debit";
	txtArray[126]["status"] = "increasing";
	
	txtArray[127]["acctName"] = "Fuel\rExp.";
	txtArray[127]["answer"] = "credit";
	txtArray[127]["status"] = "decreasing";

	txtArray[128]["acctName"] = "Fuel\rExp.";
	txtArray[128]["answer"] = "debit";
	txtArray[128]["status"] = "normal";		

	txtArray[129]["acctName"] = "Misc.\rExp.";
	txtArray[129]["answer"] = "debit";
	txtArray[129]["status"] = "increasing";
	
	txtArray[130]["acctName"] = "Misc.\rExp.";
	txtArray[130]["answer"] = "credit";
	txtArray[130]["status"] = "decreasing";

	txtArray[131]["acctName"] = "Misc.\rExp.";
	txtArray[131]["answer"] = "debit";
	txtArray[131]["status"] = "normal";

	txtArray[132]["acctName"] = "Fees\rReceivable";
	txtArray[132]["answer"] = "debit";
	txtArray[132]["status"] = "increasing";
	
	txtArray[133]["acctName"] = "Fees\rReceivable";
	txtArray[133]["answer"] = "credit";
	txtArray[133]["status"] = "decreasing";

	txtArray[134]["acctName"] = "Fees\rReceivable";
	txtArray[134]["answer"] = "debit";
	txtArray[134]["status"] = "normal";
		
	txtArray[135]["acctName"] = "Store\rSupplies";
	txtArray[135]["answer"] = "debit";
	txtArray[135]["status"] = "increasing";
	
	txtArray[136]["acctName"] = "Store\rSupplies";
	txtArray[136]["answer"] = "credit";
	txtArray[136]["status"] = "decreasing";

	txtArray[137]["acctName"] = "Store\rSupplies";
	txtArray[137]["answer"] = "debit";
	txtArray[137]["status"] = "normal";

	txtArray[138]["acctName"] = "Prepaid\rInterest";
	txtArray[138]["answer"] = "debit";
	txtArray[138]["status"] = "increasing";
	
	txtArray[139]["acctName"] = "Prepaid\rInterest";
	txtArray[139]["answer"] = "credit";
	txtArray[139]["status"] = "decreasing";

	txtArray[140]["acctName"] = "Prepaid\rInterest";
	txtArray[140]["answer"] = "debit";
	txtArray[140]["status"] = "normal";
		
	txtArray[141]["acctName"] = "Law\rLibrary";
	txtArray[141]["answer"] = "debit";
	txtArray[141]["status"] = "increasing";
	
	txtArray[142]["acctName"] = "Law\rLibrary";
	txtArray[142]["answer"] = "credit";
	txtArray[142]["status"] = "decreasing";

	txtArray[143]["acctName"] = "Law\rLibrary";
	txtArray[143]["answer"] = "debit";
	txtArray[143]["status"] = "normal";

	txtArray[144]["acctName"] = "Office\rEquip.";
	txtArray[144]["answer"] = "debit";
	txtArray[144]["status"] = "increasing";
	
	txtArray[145]["acctName"] = "Office\rEquip.";
	txtArray[145]["answer"] = "credit";
	txtArray[145]["status"] = "decreasing";

	txtArray[146]["acctName"] = "Office\rEquip.";
	txtArray[146]["answer"] = "debit";
	txtArray[146]["status"] = "normal";
		
	txtArray[147]["acctName"] = "Store\rEquip.";
	txtArray[147]["answer"] = "debit";
	txtArray[147]["status"] = "increasing";
	
	txtArray[148]["acctName"] = "Store\rEquip.";
	txtArray[148]["answer"] = "credit";
	txtArray[148]["status"] = "decreasing";

	txtArray[149]["acctName"] = "Store\rEquip.";
	txtArray[149]["answer"] = "debit";
	txtArray[149]["status"] = "normal";

	txtArray[150]["acctName"] = "Machinery";
	txtArray[150]["answer"] = "debit";
	txtArray[150]["status"] = "increasing";
	
	txtArray[151]["acctName"] = "Machinery";
	txtArray[151]["answer"] = "credit";
	txtArray[151]["status"] = "decreasing";

	txtArray[152]["acctName"] = "Machinery";
	txtArray[152]["answer"] = "debit";
	txtArray[152]["status"] = "normal";
		
	txtArray[153]["acctName"] = "Fees\rPayable";
	txtArray[153]["answer"] = "credit";
	txtArray[153]["status"] = "increasing";
	
	txtArray[154]["acctName"] = "Fees\rPayable";
	txtArray[154]["answer"] = "debit";
	txtArray[154]["status"] = "decreasing";

	txtArray[155]["acctName"] = "Fees\rPayable";
	txtArray[155]["answer"] = "credit";
	txtArray[155]["status"] = "normal";

	txtArray[156]["acctName"] = "Salary\rPayable";
	txtArray[156]["answer"] = "credit";
	txtArray[156]["status"] = "increasing";
	
	txtArray[157]["acctName"] = "Salary\rPayable";
	txtArray[157]["answer"] = "debit";
	txtArray[157]["status"] = "decreasing";

	txtArray[158]["acctName"] = "Salary\rPayable";
	txtArray[158]["answer"] = "credit";
	txtArray[158]["status"] = "normal";
		
	txtArray[159]["acctName"] = "Off. Sal.\rPayable";
	txtArray[159]["answer"] = "credit";
	txtArray[159]["status"] = "increasing";
	
	txtArray[160]["acctName"] = "Off. Sal.\rPayable";
	txtArray[160]["answer"] = "debit";
	txtArray[160]["status"] = "decreasing";

	txtArray[161]["acctName"] = "Off. Sal.\rPayable";
	txtArray[161]["answer"] = "credit";
	txtArray[161]["status"] = "normal";

	txtArray[162]["acctName"] = "Unearned\rFees";
	txtArray[162]["answer"] = "credit";
	txtArray[162]["status"] = "increasing";
	
	txtArray[163]["acctName"] = "Unearned\rFees";
	txtArray[163]["answer"] = "debit";
	txtArray[163]["status"] = "decreasing";

	txtArray[164]["acctName"] = "Unearned\rFees";
	txtArray[164]["answer"] = "credit";
	txtArray[164]["status"] = "normal";
		
	txtArray[165]["acctName"] = "Service\rRevenue";
	txtArray[165]["answer"] = "credit";
	txtArray[165]["status"] = "increasing";
	
	txtArray[166]["acctName"] = "Service\rRevenue";
	txtArray[166]["answer"] = "debit";
	txtArray[166]["status"] = "decreasing";

	txtArray[167]["acctName"] = "Service\rRevenue";
	txtArray[167]["answer"] = "credit";
	txtArray[167]["status"] = "normal";

	txtArray[168]["acctName"] = "Rent\rEarned";
	txtArray[168]["answer"] = "credit";
	txtArray[168]["status"] = "increasing";
	
	txtArray[169]["acctName"] = "Rent\rEarned";
	txtArray[169]["answer"] = "debit";
	txtArray[169]["status"] = "decreasing";

	txtArray[170]["acctName"] = "Rent\rEarned";
	txtArray[170]["answer"] = "credit";
	txtArray[170]["status"] = "normal";
		
	txtArray[171]["acctName"] = "Interest\rEarned";
	txtArray[171]["answer"] = "credit";
	txtArray[171]["status"] = "increasing";
	
	txtArray[172]["acctName"] = "Interest\rEarned";
	txtArray[172]["answer"] = "debit";
	txtArray[172]["status"] = "decreasing";

	txtArray[173]["acctName"] = "Interest\rEarned";
	txtArray[173]["answer"] = "credit";
	txtArray[173]["status"] = "normal";

	txtArray[174]["acctName"] = "Interest\rExp.";
	txtArray[174]["answer"] = "debit";
	txtArray[174]["status"] = "increasing";
	
	txtArray[175]["acctName"] = "Interest\rExp.";
	txtArray[175]["answer"] = "credit";
	txtArray[175]["status"] = "decreasing";

	txtArray[176]["acctName"] = "Interest\rExp.";
	txtArray[176]["answer"] = "debit";
	txtArray[176]["status"] = "normal";
		
	txtArray[177]["acctName"] = "Postage\rExp.";
	txtArray[177]["answer"] = "debit";
	txtArray[177]["status"] = "increasing";
	
	txtArray[178]["acctName"] = "Postage\rExp.";
	txtArray[178]["answer"] = "credit";
	txtArray[178]["status"] = "decreasing";

	txtArray[179]["acctName"] = "Postage\rExp.";
	txtArray[179]["answer"] = "debit";
	txtArray[179]["status"] = "normal";

	txtArray[180]["acctName"] = "Property\rTax Exp.";
	txtArray[180]["answer"] = "debit";
	txtArray[180]["status"] = "increasing";
	
	txtArray[181]["acctName"] = "Property\rTax Exp.";
	txtArray[181]["answer"] = "credit";
	txtArray[181]["status"] = "decreasing";

	txtArray[182]["acctName"] = "Property\rTax Exp.";
	txtArray[182]["answer"] = "debit";
	txtArray[182]["status"] = "normal";
		
	txtArray[183]["acctName"] = "Travel\rExp.";
	txtArray[183]["answer"] = "debit";
	txtArray[183]["status"] = "increasing";
	
	txtArray[184]["acctName"] = "Travel\rExp.";
	txtArray[184]["answer"] = "credit";
	txtArray[184]["status"] = "decreasing";

	txtArray[185]["acctName"] = "Travel\rExp.";
	txtArray[185]["answer"] = "debit";
	txtArray[185]["status"] = "normal";

	txtArray[186]["acctName"] = "Phone\rExp.";
	txtArray[186]["answer"] = "debit";
	txtArray[186]["status"] = "increasing";
	
	txtArray[187]["acctName"] = "Phone\rExp.";
	txtArray[187]["answer"] = "credit";
	txtArray[187]["status"] = "decreasing";

	txtArray[188]["acctName"] = "Phone\rExp.";
	txtArray[188]["answer"] = "debit";
	txtArray[188]["status"] = "normal";
		
	return txtArray;
}
//----------------------------------------------------
// Function: CreateDrCrLvl2Array
// Description: used by the _root timeline of drcr.fla.
// Pre-Condition: _G_LVL2DRCRTOTALTOPICS should match the number of row items in the array
// 			 created by this function. ***
// Output: Returns the array with all the account names for level 2.
//----------------------------------------------------
function CreateDrCrLvl2Array() {
	var txtArray = new Array(_G_LVL2DRCRTOTALTOPICS);
	
	for (var i = 0; i < _G_LVL2DRCRTOTALTOPICS; i++) {
		txtArray[i] = new Array(3);
	}
	txtArray[0]["acctName"] = "Notes\rReceivable";
	txtArray[0]["answer"] = "debit";
	txtArray[0]["status"] = "increasing";
	
	txtArray[1]["acctName"] = "Notes\rReceivable";
	txtArray[1]["answer"] = "credit";
	txtArray[1]["status"] = "decreasing";

	txtArray[2]["acctName"] = "Notes\rReceivable";
	txtArray[2]["answer"] = "debit";
	txtArray[2]["status"] = "normal";

	txtArray[3]["acctName"] = "Notes\rPayable";
	txtArray[3]["answer"] = "credit";
	txtArray[3]["status"] = "increasing";
	
	txtArray[4]["acctName"] = "Notes\rPayable";
	txtArray[4]["answer"] = "debit";
	txtArray[4]["status"] = "decreasing";

	txtArray[5]["acctName"] = "Notes\rPayable";
	txtArray[5]["answer"] = "credit";
	txtArray[5]["status"] = "normal";
		
	txtArray[6]["acctName"] = "Accum.\rAmort.";
	txtArray[6]["answer"] = "credit";
	txtArray[6]["status"] = "increasing";
	
	txtArray[7]["acctName"] = "Accum.\rAmort.";
	txtArray[7]["answer"] = "debit";
	txtArray[7]["status"] = "decreasing";

	txtArray[8]["acctName"] = "Accum.\rAmort.";
	txtArray[8]["answer"] = "credit";
	txtArray[8]["status"] = "normal";

	txtArray[9]["acctName"] = "Amort.\rExp.";
	txtArray[9]["answer"] = "debit";
	txtArray[9]["status"] = "increasing";
	
	txtArray[10]["acctName"] = "Amort.\rExp.";
	txtArray[10]["answer"] = "credit";
	txtArray[10]["status"] = "decreasing";

	txtArray[11]["acctName"] = "Amort.\rExp.";
	txtArray[11]["answer"] = "debit";
	txtArray[11]["status"] = "normal";
		
	txtArray[12]["acctName"] = "Sales";
	txtArray[12]["answer"] = "credit";
	txtArray[12]["status"] = "increasing";
	
	txtArray[13]["acctName"] = "Sales";
	txtArray[13]["answer"] = "debit";
	txtArray[13]["status"] = "decreasing";

	txtArray[14]["acctName"] = "Sales";
	txtArray[14]["answer"] = "credit";
	txtArray[14]["status"] = "normal";
		
	txtArray[15]["acctName"] = "Merch.\rInventory";
	txtArray[15]["answer"] = "debit";
	txtArray[15]["status"] = "increasing";
	
	txtArray[16]["acctName"] = "Merch.\rInventory";
	txtArray[16]["answer"] = "credit";
	txtArray[16]["status"] = "decreasing";

	txtArray[17]["acctName"] = "Merch.\rInventory";
	txtArray[17]["answer"] = "debit";
	txtArray[17]["status"] = "normal";
		
	txtArray[18]["acctName"] = "Parts\rInventory";
	txtArray[18]["answer"] = "debit";
	txtArray[18]["status"] = "increasing";
	
	txtArray[19]["acctName"] = "Parts\rInventory";
	txtArray[19]["answer"] = "credit";
	txtArray[19]["status"] = "decreasing";

	txtArray[20]["acctName"] = "Parts\rInventory";
	txtArray[20]["answer"] = "debit";
	txtArray[20]["status"] = "normal";
		
	txtArray[21]["acctName"] = "Sales\rReturns";
	txtArray[21]["answer"] = "debit";
	txtArray[21]["status"] = "increasing";
	
	txtArray[22]["acctName"] = "Sales\rReturns";
	txtArray[22]["answer"] = "credit";
	txtArray[22]["status"] = "decreasing";

	txtArray[23]["acctName"] = "Sales\rReturns";
	txtArray[23]["answer"] = "debit";
	txtArray[23]["status"] = "normal";
		
	txtArray[24]["acctName"] = "Sales\rAllowance";
	txtArray[24]["answer"] = "debit";
	txtArray[24]["status"] = "increasing";
	
	txtArray[25]["acctName"] = "Sales\rAllowance";
	txtArray[25]["answer"] = "credit";
	txtArray[25]["status"] = "decreasing";

	txtArray[26]["acctName"] = "Sales\rAllowance";
	txtArray[26]["answer"] = "debit";
	txtArray[26]["status"] = "normal";
		
	txtArray[27]["acctName"] = "Sales\rDiscount";
	txtArray[27]["answer"] = "debit";
	txtArray[27]["status"] = "increasing";
	
	txtArray[28]["acctName"] = "Sales\rDiscount";
	txtArray[28]["answer"] = "credit";
	txtArray[28]["status"] = "decreasing";

	txtArray[29]["acctName"] = "Sales\rDiscount";
	txtArray[29]["answer"] = "debit";
	txtArray[29]["status"] = "normal";
		
	txtArray[30]["acctName"] = "Cost of\rGoods Sold";
	txtArray[30]["answer"] = "debit";
	txtArray[30]["status"] = "increasing";
	
	txtArray[31]["acctName"] = "Cost of\rGoods Sold";
	txtArray[31]["answer"] = "credit";
	txtArray[31]["status"] = "decreasing";

	txtArray[32]["acctName"] = "Cost of\rGoods Sold";
	txtArray[32]["answer"] = "debit";
	txtArray[32]["status"] = "normal";
		
	txtArray[33]["acctName"] = "Delivery\rExp.";
	txtArray[33]["answer"] = "debit";
	txtArray[33]["status"] = "increasing";
	
	txtArray[34]["acctName"] = "Delivery\rExp.";
	txtArray[34]["answer"] = "credit";
	txtArray[34]["status"] = "decreasing";

	txtArray[35]["acctName"] = "Delivery\rExp.";
	txtArray[35]["answer"] = "debit";
	txtArray[35]["status"] = "normal";
		
	txtArray[36]["acctName"] = "Admin.\rExp.";
	txtArray[36]["answer"] = "debit";
	txtArray[36]["status"] = "increasing";
	
	txtArray[37]["acctName"] = "Admin.\rExp.";
	txtArray[37]["answer"] = "credit";
	txtArray[37]["status"] = "decreasing";

	txtArray[38]["acctName"] = "Admin.\rExp.";
	txtArray[38]["answer"] = "debit";
	txtArray[38]["status"] = "normal";
		
	txtArray[39]["acctName"] = "Selling\rExp.";
	txtArray[39]["answer"] = "debit";
	txtArray[39]["status"] = "increasing";
	
	txtArray[40]["acctName"] = "Selling\rExp.";
	txtArray[40]["answer"] = "credit";
	txtArray[40]["status"] = "decreasing";

	txtArray[41]["acctName"] = "Selling\rExp.";
	txtArray[41]["answer"] = "debit";
	txtArray[41]["status"] = "normal";
		
	return txtArray;	
}
//----------------------------------------------------
// Function: CreateDrCrLvl3Array
// Description: Used by the _root timeline of drcr.fla.
// Pre-Condition: _G_LVL3DRCRTOTALTOPICS must match the number of row items in the array
// 			 created by this function. ***
// Output: Returns the array with all the account names for level 3.
//----------------------------------------------------
function CreateDrCrLvl3Array() {
	var txtArray = new Array(_G_LVL3DRCRTOTALTOPICS);
	
	for (var i = 0; i < _G_LVL3DRCRTOTALTOPICS; i++) {
		txtArray[i] = new Array(3);
	}
	txtArray[0]["acctName"] = "Petty\rCash";
	txtArray[0]["answer"] = "debit";
	txtArray[0]["status"] = "increasing";
	
	txtArray[1]["acctName"] = "Petty\rCash";
	txtArray[1]["answer"] = "credit";
	txtArray[1]["status"] = "decreasing";

	txtArray[2]["acctName"] = "Petty\rCash";
	txtArray[2]["answer"] = "debit";
	txtArray[2]["status"] = "normal";
	
	txtArray[3]["acctName"] = "Cash\rEquiv.";
	txtArray[3]["answer"] = "debit";
	txtArray[3]["status"] = "increasing";
	
	txtArray[4]["acctName"] = "Cash\rEquiv.";
	txtArray[4]["answer"] = "credit";
	txtArray[4]["status"] = "decreasing";

	txtArray[5]["acctName"] = "Cash\rEquiv.";
	txtArray[5]["answer"] = "debit";
	txtArray[5]["status"] = "normal";
		
	txtArray[6]["acctName"] = "AFDA";
	txtArray[6]["answer"] = "credit";
	txtArray[6]["status"] = "increasing";
	
	txtArray[7]["acctName"] = "AFDA";
	txtArray[7]["answer"] = "debit";
	txtArray[7]["status"] = "decreasing";

	txtArray[8]["acctName"] = "AFDA";
	txtArray[8]["answer"] = "credit";
	txtArray[8]["status"] = "normal";
		
	txtArray[9]["acctName"] = "Mineral\rDeposit";
	txtArray[9]["answer"] = "debit";
	txtArray[9]["status"] = "increasing";
	
	txtArray[10]["acctName"] = "Mineral\rDeposit";
	txtArray[10]["answer"] = "credit";
	txtArray[10]["status"] = "decreasing";

	txtArray[11]["acctName"] = "Mineral\rDeposit";
	txtArray[11]["answer"] = "debit";
	txtArray[11]["status"] = "normal";
		
	txtArray[12]["acctName"] = "\rLeaseholds";
	txtArray[12]["answer"] = "debit";
	txtArray[12]["status"] = "increasing";
	
	txtArray[13]["acctName"] = "\rLeaseholds";
	txtArray[13]["answer"] = "credit";
	txtArray[13]["status"] = "decreasing";

	txtArray[14]["acctName"] = "\rLeaseholds";
	txtArray[14]["answer"] = "debit";
	txtArray[14]["status"] = "normal";
		
	txtArray[15]["acctName"] = "Leaseholds\rImprvmts.";
	txtArray[15]["answer"] = "debit";
	txtArray[15]["status"] = "increasing";
	
	txtArray[16]["acctName"] = "Leaseholds\rImprvmts.";
	txtArray[16]["answer"] = "credit";
	txtArray[16]["status"] = "decreasing";

	txtArray[17]["acctName"] = "Leaseholds\rImprvmts.";
	txtArray[17]["answer"] = "debit";
	txtArray[17]["status"] = "normal";
		
	txtArray[18]["acctName"] = "Land\rImprvmts.";
	txtArray[18]["answer"] = "debit";
	txtArray[18]["status"] = "increasing";
	
	txtArray[19]["acctName"] = "Land\rImprvmts.";
	txtArray[19]["answer"] = "credit";
	txtArray[19]["status"] = "decreasing";

	txtArray[20]["acctName"] = "Land\rImprvmts.";
	txtArray[20]["answer"] = "debit";
	txtArray[20]["status"] = "normal";
		
	txtArray[21]["acctName"] = "Patents";
	txtArray[21]["answer"] = "debit";
	txtArray[21]["status"] = "increasing";
	
	txtArray[22]["acctName"] = "Patents";
	txtArray[22]["answer"] = "credit";
	txtArray[22]["status"] = "decreasing";

	txtArray[23]["acctName"] = "Patents";
	txtArray[23]["answer"] = "debit";
	txtArray[23]["status"] = "normal";
		
	txtArray[24]["acctName"] = "Franchise";
	txtArray[24]["answer"] = "debit";
	txtArray[24]["status"] = "increasing";
	
	txtArray[25]["acctName"] = "Franchise";
	txtArray[25]["answer"] = "credit";
	txtArray[25]["status"] = "decreasing";

	txtArray[26]["acctName"] = "Franchise";
	txtArray[26]["answer"] = "debit";
	txtArray[26]["status"] = "normal";
		
	txtArray[27]["acctName"] = "Org.\rCost";
	txtArray[27]["answer"] = "debit";
	txtArray[27]["status"] = "increasing";
	
	txtArray[28]["acctName"] = "Org.\rCost";
	txtArray[28]["answer"] = "credit";
	txtArray[28]["status"] = "decreasing";

	txtArray[29]["acctName"] = "Org.\rCost";
	txtArray[29]["answer"] = "debit";
	txtArray[29]["status"] = "normal";
		
	txtArray[30]["acctName"] = "ST Note\rPayable";
	txtArray[30]["answer"] = "credit";
	txtArray[30]["status"] = "increasing";
	
	txtArray[31]["acctName"] = "ST Note\rPayable";
	txtArray[31]["answer"] = "debit";
	txtArray[31]["status"] = "decreasing";

	txtArray[32]["acctName"] = "ST Note\rPayable";
	txtArray[32]["answer"] = "credit";
	txtArray[32]["status"] = "normal";
		
	txtArray[33]["acctName"] = "LT Note\rPayable";
	txtArray[33]["answer"] = "credit";
	txtArray[33]["status"] = "increasing";
	
	txtArray[34]["acctName"] = "LT Note\rPayable";
	txtArray[34]["answer"] = "debit";
	txtArray[34]["status"] = "decreasing";

	txtArray[35]["acctName"] = "LT Note\rPayable";
	txtArray[35]["answer"] = "credit";
	txtArray[35]["status"] = "normal";
		
	txtArray[36]["acctName"] = "Warranty\rLiabilty";
	txtArray[36]["answer"] = "credit";
	txtArray[36]["status"] = "increasing";
	
	txtArray[37]["acctName"] = "Warranty\rLiabilty";
	txtArray[37]["answer"] = "debit";
	txtArray[37]["status"] = "decreasing";

	txtArray[38]["acctName"] = "Warranty\rLiabilty";
	txtArray[38]["answer"] = "credit";
	txtArray[38]["status"] = "normal";
		
	txtArray[39]["acctName"] = "Dividend\rPayable";
	txtArray[39]["answer"] = "credit";
	txtArray[39]["status"] = "increasing";
	
	txtArray[40]["acctName"] = "Dividend\rPayable";
	txtArray[40]["answer"] = "debit";
	txtArray[40]["status"] = "decreasing";

	txtArray[41]["acctName"] = "Dividend\rPayable";
	txtArray[41]["answer"] = "credit";
	txtArray[41]["status"] = "normal";
		
	txtArray[42]["acctName"] = "UI\rPayable";
	txtArray[42]["answer"] = "credit";
	txtArray[42]["status"] = "increasing";
	
	txtArray[43]["acctName"] = "UI\rPayable";
	txtArray[43]["answer"] = "debit";
	txtArray[43]["status"] = "decreasing";

	txtArray[44]["acctName"] = "UI\rPayable";
	txtArray[44]["answer"] = "credit";
	txtArray[44]["status"] = "normal";
		
	txtArray[45]["acctName"] = "CPP\rPayable";
	txtArray[45]["answer"] = "credit";
	txtArray[45]["status"] = "increasing";
	
	txtArray[46]["acctName"] = "CPP\rPayable";
	txtArray[46]["answer"] = "debit";
	txtArray[46]["status"] = "decreasing";

	txtArray[47]["acctName"] = "CPP\rPayable";
	txtArray[47]["answer"] = "credit";
	txtArray[47]["status"] = "normal";
		
	txtArray[48]["acctName"] = "Common\rShares";
	txtArray[48]["answer"] = "credit";
	txtArray[48]["status"] = "increasing";
	
	txtArray[49]["acctName"] = "Common\rShares";
	txtArray[49]["answer"] = "debit";
	txtArray[49]["status"] = "decreasing";

	txtArray[50]["acctName"] = "Common\rShares";
	txtArray[50]["answer"] = "credit";
	txtArray[50]["status"] = "normal";
		
	txtArray[51]["acctName"] = "C/S Div.\rDistrib.";
	txtArray[51]["answer"] = "credit";
	txtArray[51]["status"] = "increasing";
	
	txtArray[52]["acctName"] = "C/S Div.\rDistrib.";
	txtArray[52]["answer"] = "debit";
	txtArray[52]["status"] = "decreasing";

	txtArray[53]["acctName"] = "C/S Div.\rDistrib.";
	txtArray[53]["answer"] = "credit";
	txtArray[53]["status"] = "normal";
		
	txtArray[54]["acctName"] = "Preferred\rShares";
	txtArray[54]["answer"] = "credit";
	txtArray[54]["status"] = "increasing";
	
	txtArray[55]["acctName"] = "Preferred\rShares";
	txtArray[55]["answer"] = "debit";
	txtArray[55]["status"] = "decreasing";

	txtArray[56]["acctName"] = "Preferred\rShares";
	txtArray[56]["answer"] = "credit";
	txtArray[56]["status"] = "normal";
		
	txtArray[57]["acctName"] = "Retained\rEarnings";
	txtArray[57]["answer"] = "credit";
	txtArray[57]["status"] = "increasing";
	
	txtArray[58]["acctName"] = "Retained\rEarnings";
	txtArray[58]["answer"] = "debit";
	txtArray[58]["status"] = "decreasing";

	txtArray[59]["acctName"] = "Retained\rEarnings";
	txtArray[59]["answer"] = "credit";
	txtArray[59]["status"] = "normal";
		
	txtArray[60]["acctName"] = "Cash Div.\rDeclared";
	txtArray[60]["answer"] = "debit";
	txtArray[60]["status"] = "increasing";
	
	txtArray[61]["acctName"] = "Cash Div.\rDeclared";
	txtArray[61]["answer"] = "credit";
	txtArray[61]["status"] = "decreasing";

	txtArray[62]["acctName"] = "Cash Div.\rDeclared";
	txtArray[62]["answer"] = "debit";
	txtArray[62]["status"] = "normal";
		
	txtArray[63]["acctName"] = "Cash\rOver/Short";
	txtArray[63]["answer"] = "debit";
	txtArray[63]["status"] = "increasing";
	
	txtArray[64]["acctName"] = "Cash\rOver/Short";
	txtArray[64]["answer"] = "credit";
	txtArray[64]["status"] = "decreasing";

	txtArray[65]["acctName"] = "Cash\rOver/Short";
	txtArray[65]["answer"] = "debit";
	txtArray[65]["status"] = "normal";
		
	txtArray[66]["acctName"] = "Bad Debt\rExp.";
	txtArray[66]["answer"] = "debit";
	txtArray[66]["status"] = "increasing";
	
	txtArray[67]["acctName"] = "Bad Debt\rExp.";
	txtArray[67]["answer"] = "credit";
	txtArray[67]["status"] = "decreasing";

	txtArray[68]["acctName"] = "Bad Debt\rExp.";
	txtArray[68]["answer"] = "debit";
	txtArray[68]["status"] = "normal";
		
	txtArray[69]["acctName"] = "Credit\rCard Exp.";
	txtArray[69]["answer"] = "debit";
	txtArray[69]["status"] = "increasing";
	
	txtArray[70]["acctName"] = "Credit\rCard Exp.";
	txtArray[70]["answer"] = "credit";
	txtArray[70]["status"] = "decreasing";

	txtArray[71]["acctName"] = "Credit\rCard Exp.";
	txtArray[71]["answer"] = "debit";
	txtArray[71]["status"] = "normal";
		
	txtArray[72]["acctName"] = "Warranty\rExp.";
	txtArray[72]["answer"] = "debit";
	txtArray[72]["status"] = "increasing";
	
	txtArray[73]["acctName"] = "Warranty\rExp.";
	txtArray[73]["answer"] = "credit";
	txtArray[73]["status"] = "decreasing";

	txtArray[74]["acctName"] = "Warranty\rExp.";
	txtArray[74]["answer"] = "debit";
	txtArray[74]["status"] = "normal";
		
	txtArray[75]["acctName"] = "Gain\ron Sale";
	txtArray[75]["answer"] = "credit";
	txtArray[75]["status"] = "increasing";
	
	txtArray[76]["acctName"] = "Gain\ron Sale";
	txtArray[76]["answer"] = "debit";
	txtArray[76]["status"] = "decreasing";

	txtArray[77]["acctName"] = "Gain\ron Sale";
	txtArray[77]["answer"] = "credit";
	txtArray[77]["status"] = "normal";
		
	txtArray[78]["acctName"] = "Loss\ron Sale";
	txtArray[78]["answer"] = "debit";
	txtArray[78]["status"] = "increasing";
	
	txtArray[79]["acctName"] = "Loss\ron Sale";
	txtArray[79]["answer"] = "credit";
	txtArray[79]["status"] = "decreasing";

	txtArray[80]["acctName"] = "Loss\ron Sale";
	txtArray[80]["answer"] = "debit";
	txtArray[80]["status"] = "normal";
		
	txtArray[81]["acctName"] = "Dividend\rRevenue";
	txtArray[81]["answer"] = "credit";
	txtArray[81]["status"] = "increasing";
	
	txtArray[82]["acctName"] = "Dividend\rRevenue";
	txtArray[82]["answer"] = "debit";
	txtArray[82]["status"] = "decreasing";

	txtArray[83]["acctName"] = "Dividend\rRevenue";
	txtArray[83]["answer"] = "credit";
	txtArray[83]["status"] = "normal";
		
	txtArray[84]["acctName"] = "Dividend\rEarned";
	txtArray[84]["answer"] = "credit";
	txtArray[84]["status"] = "increasing";
	
	txtArray[85]["acctName"] = "Dividend\rEarned";
	txtArray[85]["answer"] = "debit";
	txtArray[85]["status"] = "decreasing";

	txtArray[86]["acctName"] = "Dividend\rEarned";
	txtArray[86]["answer"] = "credit";
	txtArray[86]["status"] = "normal";
		
	txtArray[87]["acctName"] = "Gain on\rDisposal";
	txtArray[87]["answer"] = "credit";
	txtArray[87]["status"] = "increasing";
	
	txtArray[88]["acctName"] = "Gain on\rDisposal";
	txtArray[88]["answer"] = "debit";
	txtArray[88]["status"] = "decreasing";

	txtArray[89]["acctName"] = "Gain on\rDisposal";
	txtArray[89]["answer"] = "credit";
	txtArray[89]["status"] = "normal";
		
	txtArray[90]["acctName"] = "Loss on\rDisposal";
	txtArray[90]["answer"] = "debit";
	txtArray[90]["status"] = "increasing";
	
	txtArray[91]["acctName"] = "Loss on\rDisposal";
	txtArray[91]["answer"] = "credit";
	txtArray[91]["status"] = "decreasing";

	txtArray[92]["acctName"] = "Loss on\rDisposal";
	txtArray[92]["answer"] = "debit";
	txtArray[92]["status"] = "normal";
		
	txtArray[93]["acctName"] = "Temp.\rInvstmt.";
	txtArray[93]["answer"] = "debit";
	txtArray[93]["status"] = "increasing";
	
	txtArray[94]["acctName"] = "Temp.\rInvstmt.";
	txtArray[94]["answer"] = "credit";
	txtArray[94]["status"] = "decreasing";

	txtArray[95]["acctName"] = "Temp.\rInvstmt.";
	txtArray[95]["answer"] = "debit";
	txtArray[95]["status"] = "normal";
		
	txtArray[96]["acctName"] = "Marketable\rSecurities";
	txtArray[96]["answer"] = "debit";
	txtArray[96]["status"] = "increasing";
	
	txtArray[97]["acctName"] = "Marketable\rSecurities";
	txtArray[97]["answer"] = "credit";
	txtArray[97]["status"] = "decreasing";

	txtArray[98]["acctName"] = "Marketable\rSecurities";
	txtArray[98]["answer"] = "debit";
	txtArray[98]["status"] = "normal";
		
	txtArray[99]["acctName"] = "Invstmt.\rin Shares";
	txtArray[99]["answer"] = "debit";
	txtArray[99]["status"] = "increasing";
	
	txtArray[100]["acctName"] = "Invstmt.\rin Shares";
	txtArray[100]["answer"] = "credit";
	txtArray[100]["status"] = "decreasing";

	txtArray[101]["acctName"] = "Invstmt.\rin Shares";
	txtArray[101]["answer"] = "debit";
	txtArray[101]["status"] = "normal";
		
	txtArray[102]["acctName"] = "Invstmt.\rin Bonds";
	txtArray[102]["answer"] = "debit";
	txtArray[102]["status"] = "increasing";
	
	txtArray[103]["acctName"] = "Invstmt.\rin Bonds";
	txtArray[103]["answer"] = "credit";
	txtArray[103]["status"] = "decreasing";

	txtArray[104]["acctName"] = "Invstmt.\rin Bonds";
	txtArray[104]["answer"] = "debit";
	txtArray[104]["status"] = "normal";
		
	txtArray[105]["acctName"] = "Long Term\rInvstmts.";
	txtArray[105]["answer"] = "debit";
	txtArray[105]["status"] = "increasing";
	
	txtArray[106]["acctName"] = "Long Term\rInvstmts.";
	txtArray[106]["answer"] = "credit";
	txtArray[106]["status"] = "decreasing";

	txtArray[107]["acctName"] = "Long Term\rInvstmts.";
	txtArray[107]["answer"] = "debit";
	txtArray[107]["status"] = "normal";
		
	txtArray[108]["acctName"] = "Bonds\rPayable";
	txtArray[108]["answer"] = "credit";
	txtArray[108]["status"] = "increasing";
	
	txtArray[109]["acctName"] = "Bonds\rPayable";
	txtArray[109]["answer"] = "debit";
	txtArray[109]["status"] = "decreasing";

	txtArray[110]["acctName"] = "Bonds\rPayable";
	txtArray[110]["answer"] = "credit";
	txtArray[110]["status"] = "normal";
		
	txtArray[111]["acctName"] = "Disc.\rBndsPybl.";
	txtArray[111]["answer"] = "debit";
	txtArray[111]["status"] = "increasing";
	
	txtArray[112]["acctName"] = "Disc.\rBndsPybl.";
	txtArray[112]["answer"] = "credit";
	txtArray[112]["status"] = "decreasing";

	txtArray[113]["acctName"] = "Disc.\rBndsPybl.";
	txtArray[113]["answer"] = "debit";
	txtArray[113]["status"] = "normal";
		
	txtArray[114]["acctName"] = "Premium\rBndsPybl.";
	txtArray[114]["answer"] = "credit";
	txtArray[114]["status"] = "increasing";
	
	txtArray[115]["acctName"] = "Premium\rBndsPybl.";
	txtArray[115]["answer"] = "debit";
	txtArray[115]["status"] = "decreasing";

	txtArray[116]["acctName"] = "Premium\rBndsPybl.";
	txtArray[116]["answer"] = "credit";
	txtArray[116]["status"] = "normal";		

	return txtArray;	
}