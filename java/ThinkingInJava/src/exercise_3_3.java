
import java.util.*;


public class exercise_3_3 {
	
	static void f(F f){
		f.f = (float) 5.20;
		
	}
	
	public static void main(String [] args){
		F fb = new F();
		fb.f = (float) 5.2;
//		System.out.print(f.f);
	}
	
	
	
	
	private class F{
		float f;
	}
}
