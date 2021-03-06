package testjava;

import java.lang.Throwable;

public class BinarySearchTree<AnyType extends Comparable<? super AnyType>> {

	private static class BinaryNode<AnyType> {
		BinaryNode(AnyType theElement) {
			this(theElement, null, null);
		}

		public BinaryNode(AnyType theElement, BinaryNode<AnyType> lt, BinaryNode<AnyType> rt) {
			element = theElement;
			left = lt;
			right = rt;
		}

		AnyType element;
		BinaryNode<AnyType> left;
		BinaryNode<AnyType> right;

	}

	private BinaryNode<AnyType> root;

	public BinarySearchTree() {
		root = null;
	}

	public void makeEmpty() {
		root = null;
	}

	public boolean isEmpty() {
		return root == null;
	}

	public boolean contains(AnyType x) {
		return contains(x, root);
	}

//	public AnyType findMin() {
//		if (isEmpty())
//			throw new UnderflowException();
//
//		return findMin(root).element;
//	}

//	public AnyType findMax() {
//		if (isEmpty())
//			throw new UnderflowException();
//		return findMax(root).element;
//	}

	public void insert(AnyType x) {
		//root = insert(x, root);
	}

	public void remove(AnyType x) {
		//root = remove(x, root);
	}

	public void printTree() {
		// traverse the whole tree
	}

	private boolean contains(AnyType x, BinaryNode<AnyType> t){
		if(t == null)
			return false;
		int compareResult = x.compareTo(t.element);
		if(compareResult <0)
			return contains(x,t.left);
		else if(compareResult >0)
			return contains(x,t.right);
		else 
			return true;
	}
	
	
	
}
