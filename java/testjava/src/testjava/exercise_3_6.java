package testjava;

import java.util.ArrayList;
import java.util.ListIterator;

public class exercise_3_6 {

	public static void pass(int m, int n) {

		int i, j, mPrime, numLeft;
		ArrayList<Integer> L = new ArrayList<Integer>();
		for (i = 1; i <= n; i++)
			L.add(i);
		
		//the array need to be iterator
		ListIterator<Integer> iter = L.listIterator();
		
		
		Integer item = 0;
		numLeft = n;
		mPrime = m % n;
		
		
		for (i = 0; i < n; i++) {
			
			mPrime = m % numLeft;
			
			if (mPrime <= numLeft / 2) {
				//move forward by 1 step,because it has been removed
				if (iter.hasNext())
					item = iter.next();
				for (j = 0; j < mPrime; j++) {
					//��ͷѭ��
					if (!iter.hasNext())
						iter = L.listIterator();
					item = iter.next();
				}
			} else {
				for (j = 0; j < numLeft - mPrime; j++) {
					if (!iter.hasPrevious())
						iter = L.listIterator(L.size());
					item = iter.previous();
				}
			}
			System.out.print("Removed " + item + " ");
			iter.remove();
			if (!iter.hasNext())
				iter = L.listIterator();
			System.out.println();
			for (Integer x : L)
				System.out.print(x + " ");
			System.out.println();
			numLeft--;
		}
		System.out.println();
	}
}
