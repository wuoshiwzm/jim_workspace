package testjava;

public class Test {
	
	private static int[] stack = new int[10];
	private static int top = -1;

	public static void push(int a) {
		top++;
		stack[top] = a;
	}

	public static void pop() {
		if (top == -1) {
			System.out.println("empty stack , cannot pop!");
			return;
		}
		top--;
	}

	public static void main(String[] args) {
//		push(12);
//		pop();
//		push(123);
//		push(1234);
//
//		for (int i = 0; i < stack.length; i++) {
//			if (stack[i] != 0) {
//				System.out.println(stack[i]);
//			}
//		}
//		System.out.println(top);

	}

}