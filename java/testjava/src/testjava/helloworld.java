package testjava;



public class helloworld {

	public static void main(String[] args) {

		long startTime=System.currentTimeMillis();   //获取开始时间  
		output(-4539872316.200012512);	  //测试的代码段  
		long endTime=System.currentTimeMillis(); //获取结束时间  
		System.out.println("  ");
		System.out.println("程序运行时间： "+(startTime-endTime)+"ms");   
		
			
	}
	static void output(double num) {
		// 整数部分'
	
		long digit = (long) Math.abs(num);
		
		if(digit < 1) {

			System.out.print("0");

		}else{
			System.out.print(digit);
		}
		
		//小数部分
		double decimal = Math.abs(num - (long)num);
		if(decimal > 0){
			System.out.print(".");
			printdigit(decimal);
		}else{
			System.out.print("0");
		}

	}
	
	static void printdigit(double  num){
		//显示一位小数
		if(num >1){
			printdigit((long)(num / 10));
			
			System.out.print((long)num % 10);
			
		}else if(num>0 && num<1){
			
			//获取一位整数
			long digit = (long)(num * 10);

			System.out.print(digit);

			//小数点后移一位
			printdigit(num * 10 - (long)(num * 10));
		}
	}
}
