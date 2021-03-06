package testjava;

//import java.awt.List;
import java.util.List;
import java.util.ListIterator;

public class exercise3_4 {

	/**
	 * ����
	 * @param L1
	 * @param L2
	 * @param Result
	 */
	public static <AnyType extends Comparable<? super AnyType>> void union(List<AnyType> L1, List<AnyType> L2,
			List<AnyType> Result) {

		ListIterator<AnyType> iterL1 = L1.listIterator();
		ListIterator<AnyType> iterL2 = L2.listIterator();

		AnyType itemL1 = null, itemL2 = null;

		if (iterL1.hasNext() && iterL2.hasNext()) {
			itemL1 = iterL1.next();
			itemL2 = iterL2.next();
		}

		while (itemL1 != null || itemL2 != null) {
			int compareResult = itemL1.compareTo(itemL2);
			if (compareResult == 0) {
				Result.add(itemL1);
			} else {
				if (itemL1 != null)
					Result.add(itemL1);

				if (itemL2 != null)
					Result.add(itemL2);
			}

			itemL1 = iterL1.hasNext() ? iterL1.next() : null;
			itemL2 = iterL2.hasNext() ? iterL2.next() : null;
		}
	}

	/**
	 * ����
	 * 
	 * @param L1
	 * @param L2
	 * @param Result
	 */
	public static <AnyType extends Comparable<? super AnyType>> void intersection(List<AnyType> L1, List<AnyType> L2,
			List<AnyType> Result) {

		ListIterator<AnyType> iterL1 = L1.listIterator();
		ListIterator<AnyType> iterL2 = L2.listIterator();

		AnyType itemL1 = null, itemL2 = null;

		if (iterL1.hasNext() && iterL2.hasNext()) {
			itemL1 = iterL1.next();
			itemL2 = iterL2.next();
		}

		while (itemL1 != null && itemL2 != null) {
			int compareResult = itemL1.compareTo(itemL2);
			if (compareResult == 0) {
				Result.add(itemL1);
				itemL1 = iterL1.hasNext() ? iterL1.next() : null;
				itemL2 = iterL2.hasNext() ? iterL2.next() : null;
			} else if (compareResult < 0) {
				Result.add(itemL1);
				itemL1 = iterL1.hasNext() ? iterL1.next() : null;
			} else {
				Result.add(itemL2);
				itemL2 = iterL2.hasNext() ? iterL2.next() : null;
			}
		}

	}

	public static <AnyType extends Comparable<? super AnyType>> void compare() {

		int a = 123;
		int b = 12;
		int res;

	}

	public static void main(String[] args) {
		Object o = new Object();
		System.out.println(o.hashCode());
	}

}
