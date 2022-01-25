function promo(code) {
	function sum(arr) {
		let result = arr.reduce((result, value) => {
			return result + value;
		}, 0);
		return result;
	}


	if (typeof code === 'number') {
 	   const arr = [];

	   do {
	       arr.unshift(code % 10);
	       code = (code - code % 10) / 10
	   }
	   while (code);

	   if (arr.length === 8) {
	   		let odds = [], 
	   			evals = [],
	   			oddNum = [],
	   			count1k = 0,
	   			count2k = 0; 

	   		arr.filter((n, index) => {if (n%2) odds.push(index) });
	   		evals = arr.filter(n => n%2 === 0);
	   		oddNum = arr.filter(n => n%2);

	   		for (let i = 0; i < odds.length; i ++) {
	   			if ( odds[i] + 1 === odds[i + 1] && odds[i + 2] !== odds[i] + 2) {
	   				if (arr[odds[i]] < arr[odds[i + 1]] ) {
	   					count2k++;
	   					if (count2k === 2) return 2000;
	   				}
	   				count1k++;
	   				if (count1k === 2) return 1000;
	   			}
	   		}
	   	if ( sum(evals) > sum(oddNum)) {
	   		return 100;
	   	}else {
	   		return 0;
	   	}

	   }else {
	   		return "недопустимое значение";
	   }
	}else {
		return "недопустимое значение";
	}
}


document.write(`Ваш бонус: ${promo(16816445)}`);
