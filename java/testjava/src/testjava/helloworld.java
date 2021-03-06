package testjava;

public class helloworld {

	public static void main(String[] args) {

		long startTime = System.currentTimeMillis(); // 获取开始时间
		// output(-4539872316.200012512); //测试的代码段

		 AA aa = new AA(); 
		  aa.a(); 
		  A a = (A)aa; 
		  a.a(); 
		long endTime = System.currentTimeMillis(); // 获取结束时间
		System.out.println("  ");
		System.out.println("程序运行时间： " + (startTime - endTime) + "ms");
	}

	// exercise 2.8
	static void randInt(int start, int end) {

		// 生成的数组结果
		int[] result = new int[(end - start)];

		// write the array
		for (int i = 0; i < result.length; i++) {
			int pass = 1;
			if (i == 0) {
				int push = (int) (Math.random() * 100);
				System.out.println("create first random num:" + push);
				result[0] = push;
				continue;
				// break;
			} else {
				while (pass == 1) {
					int push = (int) (Math.random() * 100);
					System.out.println("create random num:" + push);
					
					int inarray = 0;
					for (int i1 = 0; i1 < result.length; i1++) {
						System.out.println("check result array:" + result[i1]);
						if (result[i1] == push) {
							System.out.println("find the same num and rerandom:" + push);
							inarray = 1;
							break;
						}
					}
					if(inarray == 0){
						System.out.println("push num to array result" + push);
						result[i] = push;
						pass =0;
					}
				}
			}

		}

		for (int i = 0; i < result.length; i++) {
			System.out.println(result[i]);
		}

	}

	// exersise 2.6
	static void paycheck(int num, int money) {
		long[] pay = new long[num];

		for (int i = 0; i < num; i++) {
			if (i == 0) {
				pay[i] = 2;
				continue;
			}
			pay[i] = pay[i - 1] * pay[i - 1];
			if (pay[i] == money) {
				System.out.println(i);
			}
		}

		for (int i = 0; i < num; i++) {

			if (pay[i] == money) {
				System.out.println("对应的下标：" + i);
			}
		}

		System.out.println(pay[num - 2]);

	}

	static void output(double num) {
		// 整数部分'

		long digit = (long) Math.abs(num);

		if (digit < 1) {

			System.out.print("0");

		} else {
			System.out.print(digit);
		}

		// 小数部分
		double decimal = Math.abs(num - (long) num);
		if (decimal > 0) {
			System.out.print(".");
			printdigit(decimal);
		} else {
			System.out.print("0");
		}

	}

	static void printdigit(double num) {
		// 显示一位小数
		if (num > 1) {
			printdigit((long) (num / 10));

			System.out.print((long) num % 10);

		} else if (num > 0 && num < 1) {

			// 获取一位整数
			long digit = (long) (num * 10);

			System.out.print(digit);

			// 小数点后移一位
			printdigit(num * 10 - (long) (num * 10));
		}
	}
}
